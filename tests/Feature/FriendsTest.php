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

    /** @test */
    public function only_valid_users_can_be_friend_requested()
    {
        // $this->withoutExceptionHandling();

        //Testing that a user should only send to valid friends in the db
        $this->actingAs($user = User::factory()->create(),'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 45,
        ])->assertStatus(404);

        //Fetching the first record which should be null
        $friendRequest = Friend::first();

        $this->assertNull($friendRequest);

        $response->assertJson([
            'errors'=> [
                'code' => 404,
                'title' => 'User not found',
                'detail' => 'Unable to locate the user with the given information',
            ]
        ]);
    }

    /** @test */
    public function friend_request_can_be_accepted()
    {
        $this->withoutExceptionHandling();

         //Create the friend requesting user first: friend 1
         $this->actingAs($user = User::factory()->create(),'api');

         //Create the friend accepting user second: friend 2
        $anotherUser = User::factory()->create();

        //Assert that friend 1 is sending the friend request successfully
        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        //Now assert that friend 2 is responding successfully to friend 1
        $response = $this->actingAs($anotherUser, 'api')
                        ->post('/api/friend-request-response', [
                            'user_id' => $user->id,
                            'status' => 1
                        ])->assertStatus(200);

        //Testing that the request is saved in a database record
        $friendRequest = Friend::first();

        //Testing that the confirmed_at field is now not empty
        $this->assertNotNull($friendRequest->confirmed_at);
    }
}
