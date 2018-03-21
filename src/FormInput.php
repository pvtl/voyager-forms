<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;
use Pvtl\VoyagerForms\Form;

class FormInput extends Model
{
    protected $fillable = [
        'form_id',
        'label',
        'class',
        'type',
        'required',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
