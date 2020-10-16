<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
// use App\Models\Post;

class UsercanViewProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_profile()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->create(),'api');
        // $posts = Post::factory()->create();

        $response = $this->get('/api/users/'.$user->id);

        $response->assertStatus(200)
            ->assertJson([
                'data'=> [
                    'type' => 'users',
                    'user_id' => $user->id,
                    'attributes' => [
                        'name'=>$user->name,
                    ]
                ],
                'links' => [
                    'self' => url('/users/'.$user->id),
                ]
            ]);
    }
}
