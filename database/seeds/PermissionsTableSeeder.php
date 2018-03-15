<?php

namespace Pvtl\VoyagerForms\Database\Seeds;

use TCG\Voyager\Models\Role;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    protected $formsPermissions = [
        'browse_forms',
        'read_forms',
        'edit_forms',
        'add_forms',
    ];

    protected $enquiriesPermissions = [
        'browse_enquiries',
        'read_enquiries',
        'edit_enquiries',
        'add_enquiries',
    ];

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->generatePermissions($this->formsPermissions, 'forms');
        $this->generatePermissions($this->enquiriesPermissions, 'form_enquiries');
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
