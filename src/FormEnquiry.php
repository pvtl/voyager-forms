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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }

    public function getDataAttribute($value)
    {
        return unserialize($value);
    }
}
