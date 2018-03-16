<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Pvtl\VoyagerForms\FormEnquiry;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class EnquiryController extends BaseVoyagerBreadController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request)
    {
        Voyager::canOrFail('browse_enquiries');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create(Request $request)
    {
        Voyager::canOrFail('add_enquiries');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        Voyager::canOrFail('add_enquiries');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show(Request $request, $id)
    {
        Voyager::canOrFail('read_enquiries');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit(Request $request, $id)
    {
        Voyager::canOrFail('edit_enquiries');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function update(Request $request, $id)
    {
        Voyager::canOrFail('edit_enquiries');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Request $request, $id)
    {
        Voyager::canOrFail('delete_enquiries');
    }
}
