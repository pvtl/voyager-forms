<?php

use Faker\Generator as Faker;

$factory->define(\Pvtl\VoyagerForms\Form::class, function (Faker $faker) {
    return [
        'title' => 'An Example Form',
        'view' => 'Path\To\View',
        'mailto' => $faker->safeEmail,
        'hook' => $faker->url,
    ];
});
