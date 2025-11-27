<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmtpConfig extends Model
{
    protected $fillable = [
        'host',
        'port',
        'encryption',
        'username_encrypted',
        'password_encrypted',
        'from_address',
        'from_name',
        'is_default',
    ];

    protected $casts = [
        'username_encrypted' => 'encrypted',
        'password_encrypted' => 'encrypted',
        'is_default' => 'boolean',
    ];
}
