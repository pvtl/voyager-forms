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
        'layout',
        'email_template',
        'message_success',
    ];

    public function inputs()
    {
        return $this->hasMany(FormInput::class)->ordered();
    }

    public function setMailToAttribute($value)
    {
        $this->attributes['mailto'] = serialize($value);
    }

    public function getMailToAttribute($value)
    {
        return unserialize($value);
    }
}
