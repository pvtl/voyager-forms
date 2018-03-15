<?php

namespace Pvtl\VoyagerForms\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FormTest extends TestCase
{
    use DatabaseMigrations;

    protected $form;

    public function setUp()
    {
        parent::setUp();

        $this->form = create('Pvtl\VoyagerForms\Form');
    }

    public function testIfFormRendersShortcodeToTheFrontend()
    {
    }

    public function testIfFormSubmitsInputFieldsCorrectly()
    {
    }

    public function testIfFormSubmissionCreatesAnEnquiry()
    {
    }
}
