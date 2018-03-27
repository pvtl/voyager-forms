<?php

namespace Pvtl\VoyagerForms\Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $setting = $this->findSetting('forms.default_to_email');

        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Default Enquiry To Email',
                'value' => 'voyager.forms@mailinator.com',
                'details' => 'The default email address to send form enquiries to',
                'type' => 'text',
                'order' => 1,
                'group' => 'Forms',
            ])->save();
        }

        $setting = $this->findSetting('forms.default_from_email');

        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Default Enquiry From Email',
                'value' => 'voyager.forms@mailinator.com',
                'details' => 'The default email address to use as the sender address for form enquiries',
                'type' => 'text',
                'order' => 2,
                'group' => 'Forms',
            ])->save();
        }
    }

    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
