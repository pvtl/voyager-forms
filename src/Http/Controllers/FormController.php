<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Pvtl\VoyagerForms\Form;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class FormController extends BaseVoyagerBreadController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(Request $request)
    {
        //
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create(Request $request)
    {
        //
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show(Request $request, $id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit(Request $request, $id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
