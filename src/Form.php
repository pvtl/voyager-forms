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
}
