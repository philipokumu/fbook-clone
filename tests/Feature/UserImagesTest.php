<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\UserImage;

use Tests\TestCase;

class UserImagesTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function images_can_be_uploaded()
    {
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');

        $file = UploadedFile::fake()->image('user-image.jpg');

        $response = $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'cover',//is it profile image, cover image etc
        ])->assertStatus(201);

        //Assert file does exist in assigned location
        Storage::disk('public')->assertExists('user-images/'.$file->hashName());

        //Ensure image info is saved on db so as to do some assertions
        $userImage = UserImage::first();

        $this->assertEquals('storage/user-images/'.$file->hashName(), $userImage->path);
        $this->assertEquals(850, $userImage->width);
        $this->assertEquals(300, $userImage->height);
        $this->assertEquals('cover', $userImage->location);
        $this->assertEquals($user->id, $userImage->user_id);

        $response->assertJson([
            'data'=>[
                'type'=>'image',
                'user_image_id'=> $userImage->id,
                'attributes'=> [
                    'path'=> url($userImage->path),
                    'width'=> $userImage->width,
                    'height'=> $userImage->height,
                    'location'=> $userImage->location,
                ]
            ],
            'self'=> [
                'links'=> url('/users'. $user->id),
            ]
        ]);

    }

    /** @test */
    public function users_are_returned_with_their_images()
    {
         //Create user
         $this->actingAs($user = User::factory()->create(),'api');

         //Create a fake file
         $file = UploadedFile::fake()->image('user-image.jpg');
 
         $this->post('/api/user-images', [
             'image' => $file,
             'width' => 850,
             'height' => 300,
             'location' => 'cover',//is it profile image, cover image etc
         ])->assertStatus(201);

         $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'profile',//is it profile image, cover image etc
        ])->assertStatus(201);

         $response = $this->get('/api/users/'.$user->id);

         $response->assertJson([
                'data'=>[
                    'type'=>'users',
                    'user_id' => $user->id,
                    'attributes' => [
                        'cover_image' => [
                            'data'=>[
                                'type'=>'image',
                                'user_image_id'=> 1,
                                'attributes'=> [],
                            ]
                        ],
                        'profile_image' => [
                            'data'=>[
                                'type'=>'image',
                                'user_image_id'=> 2,
                                'attributes'=> [],
                            ]
                        ],
                    ]
                ],
            ]);
    }

    /** @test */
    public function image_width_and_length_is_required()
    {
        $this->withoutExceptionHandling();
        //Create user
        $this->actingAs($user = User::factory()->create(),'api');

        //Create a fake file
        $file = UploadedFile::fake()->image('user-image.jpg');

        $response = $this->post('/api/user-images', [
            'image' => $file,
            'width' => '',
            'height' => '',
            'location' => '',//is it profile image, cover image etc
        ])->assertStatus(422);

        //Assert file does exist in assigned location
        // Storage::disk('public');

        // $responseString = json_decode($response->getContent(), true);

        // $this->assertArrayHasKey('image', $responseString['errors']['meta']);

        //Fetching the first record which should be null
        // $userImage = UserImage::first();

        // $this->assertNull($userImage);

        //Convert this to JSON as Laravel by default expects us to be 
        //within a web application but we are using an api with no Laravel frontend
        // $responseString = json_decode($response->getContent(), true);

        // $response->assertJson([
        //     'errors'=> [
        //         'code' => 422,
        //         'width' => 'Width is required',
        //         'height' => 'Height is required', 
        //     ]
        // ]);
    }

    /** @test */
    // public function a_body_is_required_to_leave_a_comment_on_a_post()  {
    //     //Create user
    //     $this->actingAs($user = User::factory()->create(),'api');
    //     //Create post
    //     $post = Post::factory()->create(['id'=>223]);

    //     //Create a post request
    //     $response = $this->post('/api/posts/'.$post->id.'/comment', [
    //         'body'=>''])->assertStatus(422);

    //     $responseString = json_decode($response->getContent(), true);

    //     $this->assertArrayHasKey('body', $responseString['errors']['meta']);
    // }
}
