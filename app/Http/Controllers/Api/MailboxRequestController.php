<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MailboxRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailboxRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requested_username' => 'required|string|alpha_dash|min:3',
            'domain' => 'required|string', // In real app, validate against allowed domains
        ]);

        $mailboxRequest = Auth::user()->requests()->create([
            'requested_username' => $validated['requested_username'],
            'domain' => $validated['domain'],
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Request submitted successfully', 'data' => $mailboxRequest], 201);
    }

    public function index()
    {
        return response()->json(Auth::user()->requests);
    }
}
