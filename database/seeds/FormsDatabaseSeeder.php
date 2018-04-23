<?php

use TCG\Voyager\Traits\Seedable;
use Illuminate\Database\Seeder;

class FormsDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__ . '/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('FormsMenuItemsTableSeeder');
        $this->seed('FormsDataTypesTableSeeder');
        $this->seed('FormsDataRowsTableSeeder');
        $this->seed('FormsPermissionsTableSeeder');
        $this->seed('FormsSettingsTableSeeder');
        $this->seed('FormsTableSeeder');
    }
}
