<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'image',
        'description',
        'impressum',
        'datenschutz'
    ];
}