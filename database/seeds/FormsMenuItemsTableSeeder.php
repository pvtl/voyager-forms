<?php

use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsMenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->first();
        $formsMenuItem = MenuItem::firstOrNew(['route' => 'voyager.forms.index']);

        if (!$formsMenuItem->exists) {
            $formsMenuItem->fill([
                'title' => 'Forms',
                'menu_id' => $menu->id,
                'url' => '',
                'icon_class' => 'voyager-documentation',
                'order' => 7,
            ])->save();
        }

        $formManagementMenuItem = MenuItem::firstOrNew(['title' => 'Form Management']);

        if (!$formManagementMenuItem->exists) {
            $formManagementMenuItem->fill([
                'menu_id' => $menu->id,
                'parent_id' => $formsMenuItem->id,
                'url' => '',
                'icon_class' => 'voyager-documentation',
                'order' => 1,
                'route' => 'voyager.forms.index',
            ])->save();
        }

        $enquiriesMenuItem = MenuItem::firstOrNew(['route' => 'voyager.enquiries.index']);

        if (!$enquiriesMenuItem->exists) {
            $enquiriesMenuItem->fill([
                'title' => 'Enquiries',
                'menu_id' => $menu->id,
                'parent_id' => $formsMenuItem->id,
                'url' => '',
                'icon_class' => 'voyager-mail',
                'order' => 2,
            ])->save();
        }
    }
}
