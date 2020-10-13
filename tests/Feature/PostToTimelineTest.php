<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->create(),'api');
        
        $response = $this->post('/api/posts', [
            'data'=>[
                'type'=>'posts',
                'attributes'=>[
                    'body'=>'Testing Body'
                ],
            ]
        ]);

        $post = \App\Models\Post::first();

        $response->assertStatus(201);
    }
}
