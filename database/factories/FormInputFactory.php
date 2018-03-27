<?php

use Faker\Generator as Faker;

$factory->define(\Pvtl\VoyagerForms\FormInput::class, function (Faker $faker) {
    return [
        'form_id' => factory(\Pvtl\VoyagerForms\Form::class)->create()->id,
        'label' => 'Email',
        'class' => 'form-input',
        'type' => 'email',
        'required' => true,
        'order' => 0,
    ];
});
