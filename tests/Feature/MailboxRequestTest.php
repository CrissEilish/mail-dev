<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailboxRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_mailbox()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/request-mailbox', [
            'requested_username' => 'john.doe',
            'domain' => 'example.com',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.requested_username', 'john.doe');

        $this->assertDatabaseHas('mailbox_requests', [
            'user_id' => $user->id,
            'requested_username' => 'john.doe',
            'status' => 'pending',
        ]);
    }

    public function test_user_cannot_request_invalid_username()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/request-mailbox', [
            'requested_username' => 'invalid user name', // Spaces not allowed
            'domain' => 'example.com',
        ]);

        $response->assertStatus(422);
    }
}
