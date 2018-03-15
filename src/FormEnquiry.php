<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
