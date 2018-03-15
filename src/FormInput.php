<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;
use Pvtl\VoyagerForms\Form;

class FormInput extends Model
{
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
