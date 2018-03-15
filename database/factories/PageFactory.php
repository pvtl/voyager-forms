<?php

use Faker\Generator as Faker;

$factory->define(\Pvtl\VoyagerFrontend\Page::class, function (Faker $faker) {
    return [
        'slug' => 'contact',
        'title' => 'Contact Us',
        'body' => '<p>Absolutely nothing!</p>',
    ];
});
