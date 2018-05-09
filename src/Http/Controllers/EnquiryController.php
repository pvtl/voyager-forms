<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Pvtl\VoyagerForms\{
    Form,
    Enquiry,
    Traits\DataType,
    Mail\Enquiry as EnquiryMailable
};
use Pvtl\VoyagerFrontend\Helpers\ClassEvents;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class EnquiryController extends VoyagerBaseController
{
    use DataType;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create(Request $request)
    {
        Voyager::canOrFail('add_enquiries');

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
        $formData = $request->except(['_token', 'id', 'g-recaptcha-response']);

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

        // Save the enquiry to the DB
        $enquiry = Enquiry::create([
            'form_id' => $form->id,
            'data' => $formData,
            'mailto' => $form->mailto,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ])->save();

        // Debug/Preview the email
        // return (new EnquiryMailable($form, $formData))->render();

        // Send the email
        Mail::to(array_map('trim', explode(',', $form->mailto)))
            ->send(new EnquiryMailable($form, $formData));

        return redirect()
            ->back()
            ->with('success', $form->message_success);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        Voyager::canOrFail('read_enquiries');

        $enquiry = Enquiry::findOrFail($id);

        return view('voyager-forms::enquiries.view', [
            'dataType' => $this->getDataType($request),
            'enquiry' => $enquiry,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        Voyager::canOrFail('edit_enquiries');

        $enquiry = Enquiry::findOrFail($id);

        return view('voyager-forms::enquiries.edit-add', [
            'enquiry' => $enquiry,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        Voyager::canOrFail('edit_enquiries');

        $dataType = $this->getDataType($request);

        return redirect('voyager-forms::enquiries.index')
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
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
            'secret' => setting('admin.google_recaptcha_secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ]);

        if ($response->getStatusCode() !== 200) {
            return redirect()
                ->back()
                ->with('error', 'Unable to validate Google reCAPTCHA');
        }
    }
}
