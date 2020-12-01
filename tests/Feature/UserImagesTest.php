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
}
