<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'username',
        'password_encrypted',
        'quota_mb',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'password_encrypted' => 'encrypted', // Laravel built-in encryption casting
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
