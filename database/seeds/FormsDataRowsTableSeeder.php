<?php

use Pvtl\VoyagerForms\Form;
use Pvtl\VoyagerForms\Enquiry;
use Pvtl\VoyagerForms\FormInput;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FormsDataRowsTableSeeder extends Seeder
{
    protected $tables = [
        'forms',
        'inputs',
        'enquiries',
    ];

    protected $dataRowExcludes = [
        'id',
        'data',
        'files_keys',
    ];

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tables as $table) {
            $this->generatePermissions($table);
        }
    }

    /**
     * Dynamically create permissions
     * @param $table
     */
    protected function generatePermissions($table)
    {
        $columns = Schema::getColumnListing($table);
        $dataType = DataType::where('name', $table)->first();

        foreach ($columns as $key => $value) {
            $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id, 'field' => $value]);

            if (!$dataRow->exists && !in_array($value, $this->dataRowExcludes, true)) {
                $dataRow->fill([
                    'type' => 'text',
                    'display_name' => $value,
                    'required' => 1,
                    'browse' => 1,
                    'read' => 1,
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'details' => '',
                    'order' => $key,
                ])->save();
            } elseif (!$dataRow->exists && in_array($value, $this->dataRowExcludes, true)) {
                $dataRow->fill([
                    'type' => 'text',
                    'display_name' => $value,
                    'required' => 0,
                    'browse' => 0,
                    'read' => 1,
                    'edit' => 0,
                    'add' => 1,
                    'delete' => 1,
                    'details' => '',
                    'order' => $key,
                ])->save();
            }
        }
    }
}
