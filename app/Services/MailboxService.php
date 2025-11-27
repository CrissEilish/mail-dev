<?php

namespace App\Services;

use App\Models\Mailbox;
use App\Models\User;
use App\Services\Mailbox\MailboxProviderInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MailboxService
{
    protected $provider;

    public function __construct(MailboxProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function createForUser(User $user, string $username, string $domain, int $quotaMb = 1024)
    {
        $email = $username . '@' . $domain;
        $password = Str::random(16); // Generate secure password

        // 1. Create in external provider/server
        if ($this->provider->createMailbox($email, $password, $quotaMb)) {
            // 2. Store in DB
            return Mailbox::create([
                'user_id' => $user->id,
                'email' => $email,
                'username' => $username,
                'password_encrypted' => $password, // Model casts will encrypt this
                'quota_mb' => $quotaMb,
                'status' => 'active',
            ]);
        }

        return null;
    }
}
