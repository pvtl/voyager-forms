<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Pvtl\VoyagerForms\Form;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class FormController extends BaseVoyagerBreadController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        Voyager::canOrFail('browse_forms');

        $forms = Form::all();

        return view('voyager-forms::forms.index', [
            'dataType' => Voyager::model('DataType')
                ->where('slug', '=', $this->getSlug($request))
                ->first(),
            'forms' => $forms,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create(Request $request)
    {
        Voyager::canOrFail('add_forms');

        return view('voyager-forms::forms.edit-add', [
            'dataType' => Voyager::model('DataType')
                ->where('slug', '=', $this->getSlug($request))
                ->first(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Voyager::canOrFail('add_forms');

        $dataType = Voyager::model('DataType')
            ->where('slug', '=', $this->getSlug($request))
            ->first();

        Form::create($request->all())->save();

        return redirect()
            ->back()
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
        Voyager::canOrFail('read_forms');

        $form = Form::findOrFail($id);

        return view('voyager-forms::forms.edit-add', [
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        Voyager::canOrFail('edit_forms');

        $form = Form::findOrFail($id);

        return view('voyager-forms::forms.edit-add', [
            'dataType' => Voyager::model('DataType')
                ->where('slug', '=', $this->getSlug($request))
                ->first(),
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        Voyager::canOrFail('edit_forms');

        $dataType = Voyager::model('DataType')
            ->where('slug', '=', $this->getSlug($request))
            ->first();

        $form = Form::findOrFail($id);
        $form->fill($request->all())->save();

        return redirect()
            ->back()
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
        Voyager::canOrFail('delete_forms');

        $dataType = Voyager::model('DataType')
            ->where('slug', '=', $this->getSlug($request))
            ->first();

        $form = Form::findOrFail($id);
        $form->delete();

        return redirect()
            ->back()
            ->with([
                'message' => __('voyager.generic.successfully_deleted') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
