<?php

namespace Pvtl\VoyagerForms;

use Illuminate\Database\Eloquent\Model;

class FormEnquiry extends Model
{
    protected $fillable = [
        'form_id',
        'data',
        'mailto',
        'ip_address',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
