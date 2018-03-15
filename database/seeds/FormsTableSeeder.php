<?php

namespace Pvtl\VoyagerForms\Database\Seeds;

use Pvtl\VoyagerForms\Form;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\Role;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use Illuminate\Support\Facades\DB;

class FormsTableSeeder extends Seeder
{
    protected $permissions = [
        'browse_forms',
        'read_forms',
        'edit_forms',
        'add_forms',
    ];

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->first();
        $menuItem = MenuItem::firstOrNew(['title' => 'Forms']);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'menu_id' => $menu->id,
                'url'     => '',
                'icon_class' => 'voyager-documentation',
                'order'   => 7,
                'route'   => 'voyager-forms.index',
            ])->save();
        }

        $role = Role::where('name', 'admin')->firstOrFail();

        $dataType = DataType::firstOrNew([ 'name' => 'forms']);

        if (!$dataType->exists) {
            $dataType->fill([
                'slug' => 'forms',
                'display_name_singular' => 'Form',
                'display_name_plural' => 'Forms',
                'icon' => 'voyager-documentation',
                'model_name' => '\Pvtl\VoyagerForms\Form',
                'controller' => '\Pvtl\VoyagerForms\Http\Controllers\FormController',
                'generate_permissions' => '1',
            ])->save();
        }

        foreach ($this->permissions as $permissionName) {
            $permission = Permission::firstOrNew(['key' => $permissionName]);

            if (!$permission->exists) {
                $permission->fill([
                    'table_name' => 'forms',
                ])->save();

                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
