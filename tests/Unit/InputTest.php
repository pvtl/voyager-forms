<?php

namespace Pvtl\VoyagerForms\Tests\Unit;

use Tests\TestCase;
use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerForms\FormInput;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pvtl\VoyagerForms\Tests\Utilities\FactoryUtilities;

class InputTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        \Pvtl\VoyagerForms\Tests\Unit\FormTest::createForm();
    }

    public function testIfInputHasAFormAssigned()
    {
        $input = FormInput::inRandomOrder()->get()->first();
        $form = $input->form()->first();

        return $this->assertInstanceOf(Form::class, $form);
    }

    public function testIfInputHasALabel()
    {
        $form = FormInput::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('label', $form);
    }

    public function testIfInputHasAClass()
    {
        $form = FormInput::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('class', $form);
    }

    public function testIfInputHasAType()
    {
        $form = FormInput::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('type', $form);
    }

    public function testIfInputIsRequired()
    {
        $form = FormInput::inRandomOrder()->get()->first();

        return $this->assertEquals(true, $form->required);
    }
}
