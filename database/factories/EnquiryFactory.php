<?php

use Faker\Generator as Faker;

$factory->define(\Pvtl\VoyagerForms\Enquiry::class, function (Faker $faker) {
    return [
        'form_id' => factory(\Pvtl\VoyagerForms\Form::class)->create()->id,
        'data' => json_encode([
            'first_name' => 'Jonathon',
            'last_name' => 'Spoons',
            'gender' => 'Chameleon',
            'attitude' => 'Savage',
        ]),
        'mailto' => $faker->safeEmail,
        'hook' => $faker->url,
        'ip_address' => $faker->ipv4,
    ];
});
