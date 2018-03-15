<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function formInputs()
    {
        return $this->hasMany(FormInput::class);
    }
}
