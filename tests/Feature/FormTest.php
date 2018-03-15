<?php

namespace Pvtl\VoyagerForms\Tests\Feature;

use Tests\TestCase;
use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerFrontend\Page;
use Pvtl\VoyagerForms\FormInput;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pvtl\VoyagerForms\Tests\Utilities\FactoryUtilities;

class FormTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        \Pvtl\VoyagerForms\Tests\Unit\FormTest::createForm();

        factory(Page::class)->make([
            'slug' => 'contact',
            'title' => 'Contact Us',
            'body' => Form::inRandomOrder()->get()->first()->shortcode,
        ]);
    }

    public function testIfFormRendersShortcodeToTheFrontend()
    {
        $response = $this->get('/contact');

        return $response->assertStatus(200)
            ->assertSee('My Form');
    }
}
