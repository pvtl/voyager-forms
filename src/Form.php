<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'view',
        'mailto',
        'hook',
    ];

    public function inputs()
    {
        return $this->hasMany(FormInput::class);
    }

    // Get a list of form layouts
    public function getLayouts()
    {
        $layouts = array();

        // Get list of layouts from module
        $vendorLayoutsDir = base_path('vendor/pvtl/voyager-forms/resources/views/layouts');
        if (is_dir($vendorLayoutsDir)) {
            $layouts = scandir($vendorLayoutsDir);
        }

        // Get list of layouts from project
        $projectLayoutsDir = resource_path('views/vendor/voyager-forms/layouts');
        if (is_dir($projectLayoutsDir)) {
            $layouts = array_merge($layouts, scandir($projectLayoutsDir));
        }

        foreach ($layouts as $i => $layout) {
            // Only include files that are .blade.php files
            if (strpos($layout, '.blade.php') === false) {
                unset($layouts[$i]);
                continue;
            }

            // Strip out .blade.php for DB reference
            $layouts[$i] = str_replace('.blade.php', '', $layout);
        }

        // Remove duplicates
        $layouts = array_unique($layouts);

        // Reset indexes
        $layouts = array_values($layouts);

        // Reset indexes and return
        return $layouts;
    }
}
