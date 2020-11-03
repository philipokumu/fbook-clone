<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Friend;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_retrieve_posts()
    {
        //We need a user 1
        $this->actingAs($user = User::factory()->create(),'api'); 
        //We need another user to retrieve their posts too if they are friends with user 1
        $anotherUser = User::factory()->create(); 

        $posts = Post::factory(2)->create(['user_id' => $anotherUser->id]); //We need some posts
        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'confirmed_at' => now(),
            'status' => 1,
        ]);

        $response = $this->get('/api/posts'); //We need the api to be accessed for this posts

        $response->assertStatus(200) //We need to assert everything is okay
            ->assertJson([ //We need to assert the correct JSON format is returned
                'data' => [
                    [
                        'data'=> [
                            'type' => 'posts',
                            'post_id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                                'image' => $posts->last()->image,
                                'posted_at' => $posts->last()->created_at->diffForHumans(), 
                            ]
                        ]
                    ],
                    [
                        'data'=> [
                            'type' => 'posts',
                            'post_id' => $posts->first()->id,
                            'attributes' => [
                                'body' => $posts->first()->body,
                                'image' => $posts->last()->image,
                                'posted_at' => $posts->first()->created_at->diffForHumans(), 
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/posts')
                ]
            ]);

    }

    /** @test */
    public function a_user_can_only_retrieve_their_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->create(),'api'); //We need a user

        $posts = Post::factory()->create(); //We need some posts

        $response = $this->get('/api/posts'); //We need the api to be accessed for this posts

        $response->assertStatus(200)
            ->assertExactJson([
                'data'=> [],
                'links' => [
                    'self' => url('/posts')
                ]
            ]);
    }

}
