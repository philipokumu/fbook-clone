<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;

use Tests\TestCase;

class PostCommentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_user_can_comment_on_a_post()  {
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');
        //Create post
        $post = Post::factory()->create(['id'=>223]);

        //Create a post request
        $response = $this->post('/api/posts/'.$post->id.'/comment', [
            'body'=>'A great comment here'])
            ->assertStatus(200);

        $comment = Comment::first();
        $this->assertCount(1, Comment::all());
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
        $this->assertEquals('A great comment here', $comment->body);

        $response->assertJson([
            'data'=>[
                [
                    'data'=> [
                        'type'=> 'comments',
                        'comment_id'=>1,
                        'attributes'=>[
                            'commented_by'=> [
                                'data'=> [
                                    'user_id'=>$user->id,
                                    'attributes' => [
                                        'name'=> $user->name,
                                    ]
                                ]
                            ],
                            'body'=> 'A great comment here',
                            'commented_at'=> $comment->created_at->diffForHumans(),
                        ],
                    ],
                    'links'=>[
                        'self'=>url('/posts/223'),
                    ]
                ]
            ],'links'=>[
                'self'=>url('/posts'),
            ]
        ]);
    }

    /** @test */
    public function a_body_is_required_to_leave_a_comment_on_a_post()  {
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');
        //Create post
        $post = Post::factory()->create(['id'=>223]);

        //Create a post request
        $response = $this->post('/api/posts/'.$post->id.'/comment', [
            'body'=>''])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('body', $responseString['errors']['meta']);
    }

    /** @test */
    public function posts_are_returned_with_comments()  {
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');
        //Create post
        $post = Post::factory()->create(['id'=>223,'user_id'=>$user->id]);

        //Create a post request
        $this->post('/api/posts/'.$post->id.'/comment', [
            'body'=>'A great comment here']);

        $response = $this->get('/api/posts');

        $comment = Comment::first();

        $response->assertStatus(200)
            ->assertJson([
                'data'=> [
                [
                    'data'=>[
                        'type'=>'posts',
                        'attributes'=>[
                            'comments'=> [
                                'data'=> [
                                    [
                                        'data'=> [
                                            'type'=> 'comments',
                                            'comment_id'=>1,
                                            'attributes'=>[
                                                'commented_by'=> [
                                                    'data'=> [
                                                        'user_id'=>$user->id,
                                                        'attributes' => [
                                                            'name'=> $user->name,
                                                        ]
                                                    ]
                                                ],
                                                'body'=> 'A great comment here',
                                                'commented_at'=> $comment->created_at->diffForHumans(),
                                            ],
                                        ],
                                        'links'=>[
                                            'self'=>url('/posts/223'),
                                        ]
                                    ]
                                ],
                                'comment_count' => 1,
                            ]
                        ]
                    ]
                ]
            ]

            ]);

    }
}
