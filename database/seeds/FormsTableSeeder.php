<?php

namespace Pvtl\VoyagerForms\Database\Seeds;

use Illuminate\Database\Seeder;
use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerForms\FormInput;

class FormsTableSeeder extends Seeder
{
    protected $inputs = [
        'first_name' => 'text',
        'last_name' => 'text',
        'email' => 'email',
        'comments' => 'text_area',
    ];

    public function run()
    {
        $form = $this->findForm('Contact Us');

        if (!$form->exists) {
            $form->fill([
                'title' => 'Contact Us',
                'mailto' => 'tech@pvtl.io',
                'layout' => 'default',
            ])->save();

            $this->createFormInputs($form);
        }
    }

    protected function findForm($title)
    {
        return Form::firstOrNew(['title' => $title]);
    }

    protected function createFormInputs($form)
    {
        foreach ($this->inputs as $key => $value) {
            FormInput::create([
                'form_id' => $form->id,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => $value,
                'required' => 1,
            ])->save();
        }
    }
}
