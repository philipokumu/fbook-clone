<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class LikesTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function a_user_can_like_a_post()
    {
        $this->withoutExceptionHandling();
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');
        //Create post
        $post = Post::factory()->create(['id'=>123]);

        //Create a post request
        $response = $this->post('/api/posts/'.$post->id.'/like')
            ->assertStatus(200);

        $this->assertCount(1,$user->likedPosts);
        $response->assertJson([
            'data'=>[
                [
                    'data'=> [
                        'type'=> 'likes',
                        'like_id'=>1,
                        'attributes'=>[]
                    ],
                    'links'=>[
                        'self'=>url('/posts/123'),
                    ]
                ]
            ],'links'=>[
                'self'=>url('/posts'),
            ]
        ]);

    }

    /** @test */
    public function posts_are_returned_with_likes()
    {
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');
        //Create post
        $post = Post::factory()->create(['id'=>123, 'user_id'=>$user->id]);

        //Create a post request
        $this->post('/api/posts/'.$post->id.'/like')->assertStatus(200);

        $response = $this->get('/api/posts')
            ->assertStatus(200)
            ->assertJson([
                'data'=>[
                    [
                        'data'=>[
                            'type'=>'posts',
                            'attributes'=>[
                                'likes'=> [
                                    'data'=> [
                                        [
                                            'data'=> [
                                                'type'=>'likes',
                                                'like_id'=>1,
                                                'attributes'=>[]
                                            ]
                                        ]
                                    ],
                                    'like_count' => 1,
                                    'user_likes_post'=> true,
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        
    }
}
