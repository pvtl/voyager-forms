<?php

use TCG\Voyager\Models\Setting;
use Illuminate\Database\Seeder;

class FormsSettingsTableSeeder extends Seeder
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

        $setting = $this->findSetting('admin.google_recaptcha_site_key');

        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google reCAPTCHA Site Key (public)',
                'value' => '',
                'details' => 'This key can be found in your Google reCAPTCHA console',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.google_recaptcha_secret_key');

        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google reCAPTCHA Secret Key',
                'value' => '',
                'details' => 'This key can be found in your Google reCAPTCHA console',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ])->save();
        }
    }

    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
