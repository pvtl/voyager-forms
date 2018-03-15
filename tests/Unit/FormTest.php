<?php

namespace Pvtl\VoyagerForms\Tests\Unit;

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

    public function testIfFormHasATitle()
    {
    }

    public function testIfFormHasInputsAssigned()
    {
    }

    public function testIfFormHasAViewAssigned()
    {
    }

    public function testIfFormHasAMailToAddress()
    {
    }

    public function testIfFormHasASubmissionHook()
    {
    }
}
