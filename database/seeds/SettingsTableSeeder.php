<?php

namespace Pvtl\VoyagerForms\Database\Seeds;

use \Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $setting = $this->findSetting('forms.default_email');

        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Default Enquiry Email',
                'value' => '',
                'details' => 'The default email address to send form enquiries to',
                'type' => 'text',
                'order' => 1,
                'group' => 'Forms',
            ])->save();
        }
    }

    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}