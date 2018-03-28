<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use Pvtl\VoyagerForms\Form;
use TCG\Voyager\Facades\Voyager;
use Pvtl\VoyagerForms\FormEnquiry;
use Illuminate\Support\Facades\Mail;
use Pvtl\VoyagerForms\Traits\DataType;
use Pvtl\VoyagerFrontend\Helpers\ClassEvents;
use Pvtl\VoyagerForms\Mail\Enquiry as EnquiryMailable;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class EnquiryController extends BaseVoyagerBreadController
{
    use DataType;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        Voyager::canOrFail('browse_enquiries');

        $enquiries = FormEnquiry::all();

        return view('voyager-forms::enquiries.index', [
            'dataType' => $this->getDataType($request),
            'enquiries' => $enquiries,
        ]);
    }

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
     * This store method is triggered by any front-end forms generated
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
        $formData = $request->except(['_token', 'id']);

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
        $enquiry = FormEnquiry::create([
            'form_id' => $form->id,
            'data' => $formData,
            'mailto' => $form->mailto,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ])->save();

        // Debug/Preview the email
        // return (new EnquiryMailable($form, $formData))->render();

        // Send the email
        Mail::to(explode(',', $form->mailto))
            ->send(new EnquiryMailable($form, $formData));

        return redirect()
            ->back()
            ->with('success', "Form submitted successfully");
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        Voyager::canOrFail('read_enquiries');

        $enquiry = FormEnquiry::findOrFail($id);

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

        $enquiry = FormEnquiry::findOrFail($id);

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
                'message' => __('voyager.generic.successfully_updated') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        Voyager::canOrFail('delete_enquiries');

        $enquiry = FormEnquiry::findOrFail($id);
        $dataType = $this->getDataType($request);

        $enquiry->delete();

        return redirect()
            ->back()
            ->with([
                'message' => __('voyager.generic.successfully_deleted') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
