<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailboxController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->mailboxes);
    }

    public function show($id)
    {
        $mailbox = Auth::user()->mailboxes()->findOrFail($id);

        // Decrypt password for display
        $data = $mailbox->toArray();
        $data['password'] = $mailbox->password_encrypted; // Cast handles decryption

        return response()->json($data);
    }
}
