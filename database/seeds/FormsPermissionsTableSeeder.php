<?php

use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsPermissionsTableSeeder extends Seeder
{
    protected $formsPermissions = [
        'browse_forms',
        'edit_forms',
        'add_forms',
        'delete_forms',
    ];

    protected $inputsPermissions = [
        'browse_inputs',
        'read_inputs',
        'edit_inputs',
        'add_inputs',
        'delete_inputs',
    ];

    protected $enquiriesPermissions = [
        'browse_enquiries',
        'read_enquiries',
        'delete_enquiries',
    ];

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->generatePermissions($this->formsPermissions, 'forms');
        $this->generatePermissions($this->inputsPermissions, 'form_inputs');
        $this->generatePermissions($this->enquiriesPermissions, 'enquiries');
    }


    /**
     * Dynamically create permissions
     * @param $permissions
     * @param $tableName
     */
    protected function generatePermissions($permissions, $tableName)
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrNew(['key' => $permissionName]);

            if (!$permission->exists) {
                $permission->fill([
                    'table_name' => $tableName,
                ])->save();

                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
