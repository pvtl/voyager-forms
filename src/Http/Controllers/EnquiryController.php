<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use Pvtl\VoyagerForms\Traits\DataType;
use TCG\Voyager\Facades\Voyager;
use Pvtl\VoyagerForms\FormEnquiry;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Voyager::canOrFail('add_enquiries');

        $enquiry = FormEnquiry::create([]);

        return redirect('voyager-forms::enquiries.index')
            ->with([
                'message' => __('voyager.generic.successfully_added_new') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
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

        return view('voyager-forms::enquiries.edit-add', [
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

        $enquiry->delete();

        return redirect('voyager-forms::enquiries.index')
            ->with([
                'message' => __('voyager.generic.successfully_deleted') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
