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
        'options',
        'required',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'ASC');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }

    public function getOptionsAttribute($value)
    {
        return unserialize($value);
    }
}
