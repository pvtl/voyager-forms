<?php

namespace Pvtl\VoyagerForms\Http\Controllers;

use Illuminate\Http\Request;
use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerForms\FormInput;
use Pvtl\VoyagerForms\Traits\DataType;
use Pvtl\VoyagerFrontend\Helpers\Layouts;
use Pvtl\VoyagerForms\Validators\FormValidators;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class FormController extends VoyagerBaseController
{
    use DataType;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create(Request $request)
    {
        Voyager::canOrFail('add_forms');

        return view('voyager-forms::forms.edit-add', [
            'dataType' => $this->getDataType($request),
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Voyager::canOrFail('add_forms');

        $dataType = $this->getDataType($request);

        if ($request->input('hook')) {
            $validator = FormValidators::validateHook($request);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with([
                        'message' => __('voyager::json.validation_errors'),
                        'alert-type' => 'error',
                    ]);
            }
        }

        // Create the form
        $form = Form::create($request->all());

        // Create some default inputs
        $inputs = [
            'name' => 'text',
            'email' => 'email',
            'phone' => 'text',
            'message' => 'text_area',
        ];
        $order = 1;
        foreach ($inputs as $key => $value) {
            FormInput::create([
                'form_id' => $form->id,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => $value,
                'required' => 1,
                'order' => $order,
            ])->save();

            $order++;
        }

        return redirect()
            ->route('voyager.forms.edit', ['id' => $form->id])
            ->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->display_name_singular}",
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
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
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
            'dataType' => $this->getDataType($request),
            'form' => $form,
            'layouts' => Layouts::getLayouts('voyager-forms'),
            'emailTemplates' => Layouts::getLayouts('voyager-forms', 'email-templates'),
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

        $dataType = $this->getDataType($request);
        $form = Form::findOrFail($id);

        if ($request->input('hook')) {
            $validator = FormValidators::validateHook($request);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with([
                        'message' => __('voyager::json.validation_errors'),
                        'alert-type' => 'error',
                    ]);
            }
        }

        $form->fill($request->all());
        $form->save();

        return redirect()
            ->back()
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
