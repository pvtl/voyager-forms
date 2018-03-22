<?php

namespace Pvtl\VoyagerForms;

use Pvtl\VoyagerForms\Form;

class Forms
{
    protected $models = [
        'Form' => Form::class,
    ];

    protected function model($name)
    {
        return app($this->models[studly_case($name)]);
    }

    public function forms($key, $default = null)
    {
        $form = self::model('Form')->where('id', $key)->first();

        return view('voyager-forms::forms.render', [
            'form' => $form,
        ]);
    }
}
