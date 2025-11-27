<?php

namespace App\Services\Mailbox;

interface MailboxProviderInterface
{
    public function createMailbox(string $email, string $password, int $quotaMb): bool;
    public function deleteMailbox(string $email): bool;
    public function updatePassword(string $email, string $newPassword): bool;
    public function updateQuota(string $email, int $newQuotaMb): bool;
}
