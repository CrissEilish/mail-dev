<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MailboxRequest;
use App\Services\MailboxService;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    protected $mailboxService;

    public function __construct(MailboxService $mailboxService)
    {
        $this->mailboxService = $mailboxService;
    }

    public function index()
    {
        return response()->json(MailboxRequest::with('user')->where('status', 'pending')->get());
    }

    public function approve(Request $request, $id)
    {
        $mailboxRequest = MailboxRequest::findOrFail($id);

        if ($mailboxRequest->status !== 'pending') {
            return response()->json(['error' => 'Request is not pending'], 400);
        }

        $mailbox = $this->mailboxService->createForUser(
            $mailboxRequest->user,
            $mailboxRequest->requested_username,
            $mailboxRequest->domain
        );

        if ($mailbox) {
            $mailboxRequest->update(['status' => 'approved']);
            return response()->json(['message' => 'Mailbox created successfully', 'data' => $mailbox]);
        }

        return response()->json(['error' => 'Failed to create mailbox'], 500);
    }

    public function reject(Request $request, $id)
    {
        $mailboxRequest = MailboxRequest::findOrFail($id);
        $mailboxRequest->update(['status' => 'rejected']);
        return response()->json(['message' => 'Request rejected']);
    }
}
