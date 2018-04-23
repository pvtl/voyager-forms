<?php

use TCG\Voyager\Models\DataType;
use Illuminate\Database\Seeder;

class FormsDataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $formDataType = DataType::firstOrNew(['model_name' => 'Pvtl\VoyagerForms\Form']);

        if (!$formDataType->exists) {
            $formDataType->fill([
                'name' => 'forms',
                'slug' => 'forms',
                'display_name_singular' => 'Form',
                'display_name_plural' => 'Forms',
                'icon' => 'voyager-documentation',
                'controller' => '\Pvtl\VoyagerForms\Http\Controllers\FormController',
                'generate_permissions' => '1',
            ])->save();
        }

        $inputDataType = DataType::firstOrNew(['model_name' => 'Pvtl\VoyagerForms\FormInput']);

        if (!$inputDataType->exists) {
            $inputDataType->fill([
                'name' => 'inputs',
                'slug' => 'inputs',
                'display_name_singular' => 'Input',
                'display_name_plural' => 'Inputs',
                'icon' => 'voyager-documentation',
                'controller' => '\Pvtl\VoyagerForms\Http\Controllers\InputController',
                'generate_permissions' => '1',
            ])->save();
        }

        $enquiryDataType = DataType::firstOrNew(['model_name' => 'Pvtl\VoyagerForms\Enquiry']);

        if (!$enquiryDataType->exists) {
            $enquiryDataType->fill([
                'name' => 'enquiries',
                'slug' => 'enquiries',
                'display_name_singular' => 'Enquiry',
                'display_name_plural' => 'Enquiries',
                'icon' => 'voyager-mail',
                'controller' => '\Pvtl\VoyagerForms\Http\Controllers\EnquiryController',
                'generate_permissions' => '1',
                'server_side' => '1',
            ])->save();
        }
    }
}
