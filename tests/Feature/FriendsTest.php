<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Friend;

class FriendsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_send_a_friend_request()
    {
        $this->withoutExceptionHandling();

        //Testing that a user has sent out a friend request
        $this->actingAs($user = User::factory()->create(),'api');

        $anotherUser = User::factory()->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        //Testing that the request is saved in a database record
        $friendRequest = Friend::first();

        $this->assertNotNull($friendRequest);

        //Testing that the correct fields are set
        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        
        //Testing that the authenticated user is also part of this friend request
        $this->assertEquals($user->id, $friendRequest->user_id);

        //Assert that we are getting the proper confirmed friend Json response
        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ]
            ],
            'links' => [
                'self'=> url('/users/' .$anotherUser->id),
            ]
        ]);


    }
}
