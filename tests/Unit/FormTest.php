<?php

namespace Pvtl\VoyagerForms\Tests\Unit;

use Tests\TestCase;
use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerForms\FormInput;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pvtl\VoyagerForms\Tests\Utilities\FactoryUtilities;

class FormTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        self::createForm();
    }

    public function testIfFormHasInputsAssigned()
    {
        $form = Form::inRandomOrder()->get()->first();
        $input = $form->inputs()->first();

        return $this->assertInstanceOf(FormInput::class, $input);
    }

    public function testIfFormHasATitle()
    {
        $form = Form::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('title', $form);
    }

    public function testIfFormHasAViewAssigned()
    {
        $form = Form::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('view', $form);
    }

    public function testIfFormHasAMailToAddress()
    {
        $form = Form::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('mailto', $form);
    }

    public function testIfFormHasASubmissionHook()
    {
        $form = Form::inRandomOrder()->get()->first();

        return $this->assertArrayHasKey('hook', $form);
    }

    public static function createForm()
    {
        factory(Form::class, 3)
            ->create()
            ->each(function ($form) {
                $form->inputs()->save(factory(FormInput::class)->make());
            });
    }
}
