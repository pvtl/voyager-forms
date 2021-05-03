<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Pvtl\VoyagerForms\{
    Form,
    Enquiry,
    Traits\DataType,
    Mail\Enquiry as EnquiryMailable
};
use Pvtl\VoyagerFrontend\Helpers\ClassEvents;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EnquiryController extends VoyagerBaseController
{
    use DataType;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('add', app(Enquiry::class));

        return view('voyager-forms::enquiries.edit-add', [
            'dataType' => $this->getDataType($request),
        ]);
    }

    /**
     * This submit method is triggered by any front-end forms generated
     * with a shortcode - when a user submits the form it will dynamically
     * trigger a series of events that are associated with this specific form.
     *
     * Woah-ho-ho it's magic! Ya'know... never believe it ain't so.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submit(Request $request)
    {
        $form = Form::findOrFail($request->id);

        $request->validate($this->buildValidation($form));

        // Get $formData and $filesKeys verifying the MIME of files.
        $formDataAndFilesKeys = $this->getFormDataAndFilesKeys($form, $request);
        if($formDataAndFilesKeys instanceof RedirectResponse){
            return $formDataAndFilesKeys;
        }
        list($formData, $filesKeys) = $formDataAndFilesKeys;

        // Check if reCAPTCHA is on & verify
        if (setting('admin.google_recaptcha_site_key')) {
            $this->verifyCaptcha($request);
        }

        // Execute the hook
        if ($form->hook) {
            ClassEvents::executeClass($form->hook, $formData);
        }

        // The recipients
        if (empty($form->mailto)) {
            $form->mailto = !empty(setting('forms.default_to_email'))
                ? setting('forms.default_to_email')
                : 'voyager.forms@mailinator.com';
        }

        // The from address
        $form->mailfrom = !empty(setting('forms.default_from_email'))
            ? setting('forms.default_from_email')
            : 'voyager.forms@mailinator.com';

        // The from name (eg. site address)
        $form->mailfromname = !empty(setting('site.title'))
            ? setting('site.title')
            : 'Website';

        // Upload the images files, update $formData to save the image directory and return all the file keys.

        // Save the enquiry to the DB
        $enquiry = Enquiry::create([
            'form_id' => $form->id,
            'data' => $formData,
            'mailto' => $form->mailto,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'files_keys' => $filesKeys
        ])->save();

        // Debug/Preview the email
        // return (new EnquiryMailable($form, $formData, $filesKeys))->render();

        // Send the email
        Mail::to(array_map('trim', explode(',', $form->mailto)))
            ->send(new EnquiryMailable($form, $formData, $filesKeys));

        return redirect()
            ->back()
            ->with('success', $form->message_success);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, $id)
    {
        $this->authorize('read', app(Enquiry::class));

        $enquiry = Enquiry::findOrFail($id);

        //verify files and push in array your infos, unset the file path in data and update the data of $enquiry
        $files = [];
        $formData = $enquiry->data;
        foreach ($enquiry->files_keys as $fileKey) {
            if (isset($formData[$fileKey])) {
                $files[] = [
                    'url' => route('voyager.enquiries.file', [
                        'id' => $enquiry->id,
                        'fileKey' => $fileKey
                    ]),
                    'filename' => pathinfo($formData[$fileKey])['filename']
                ];
                unset($formData[$fileKey]);
            }
        }
        $enquiry->data = $formData;

        return view('voyager-forms::enquiries.view', [
            'dataType' => $this->getDataType($request),
            'enquiry' => $enquiry,
            'files' => $files
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('edit', app(Enquiry::class));

        $enquiry = Enquiry::findOrFail($id);

        return view('voyager-forms::enquiries.edit-add', [
            'enquiry' => $enquiry,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', app(Enquiry::class));

        $dataType = $this->getDataType($request);

        return redirect('voyager-forms::enquiries.index')
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    /**
     * Download the file from enquiry
     * @param $id
     * @param $fileKey
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getFile($id, $fileKey)
    {

        $this->authorize('browse', app(Enquiry::class));

        $enquiry = Enquiry::findOrFail($id);
        $formData = $enquiry->data;

        //return download if file exists
        if (isset($formData[$fileKey])) {
            return Storage::download($formData[$fileKey]);
        }
        abort(404);

    }

    /**
     * Verify the reCAPTCHA response with Google
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function verifyCaptcha(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $guzzleRequest = new \GuzzleHttp\Psr7\Request('POST', 'https://www.google.com/recaptcha/api/siteverify');
        $response = $client->send($guzzleRequest, [
            'form_params' => [
                'secret' => setting('admin.google_recaptcha_secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR'],
            ],
        ]);

        if ($response->getStatusCode() !== 200 || !json_decode($response->getBody()->getContents(), true)['success']) {
            return redirect()
                ->back()
                ->with('error', 'Unable to validate Google reCAPTCHA');
        }
    }

    /**
     * Get the Form Data and the Files Keys
     * @param $form
     * @param $request
     * @return array With form data updated and files keys|\Illuminate\Http\RedirectResponse
     */
    protected function getFormDataAndFilesKeys($form, $request)
    {
        $formData = $request->except(['_token', 'id', 'g-recaptcha-response']);
        $filesKeys = [];

        $mimes = $this->getMimesFromForm($form);

        foreach ($request->files as $key => $data) {

            //IDK WHY!!!, but the $data->storeAs(...) won't work...
            //Hack to avoid error up
            $data = $formData[$key];
            if ($data->isValid()) {
                $key_slug = Str::slug($key, '_');
                $extension = $data->getClientOriginalExtension();

                if(!in_array(".{$extension}", $mimes[$key_slug])){
                    return redirect()
                        ->back()
                        ->with('error', 'File(s) not Allowed');
                }

                $file_name = strtoupper(pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME));
                $timestamp = Carbon::now()->timestamp;
                $filepath = $data->storeAs("forms/{$key_slug}", "{$file_name}_{$timestamp}.{$extension}");
                $filesKeys[] = $key;
                $formData[$key] = "{$filepath}";
            }
        }
        return [$formData, $filesKeys];
    }

    protected function getMimesFromForm($form){
        $mimes = [];
        $inputs = $form->inputs()->where('type', 'file')->get();
        foreach($inputs as $key => $input){
            $mimes[Str::slug($input->label, '_')] = explode(',', $input->options);
        }
        return $mimes;
    }

        
    /**
     * Builds a validation array based on required / email input form fields.
     * Returns an array to be fed into the validate() function.
     *
     * @param  Form $form
     * @return array $validationArray
     */
    protected function buildValidation($form)
    {
        $validationArray = [];
        foreach ($form->inputs as $input) {
            if ($input->type === 'email') {
                $additionalValidation = '|email';
            } else {
                $additionalValidation = '';
            }

            if ($input->required) {
                $validationArray[str_replace(' ', '_', $input->label)] = 'required' . $additionalValidation;
            }
        }

        return $validationArray;
    }
}
