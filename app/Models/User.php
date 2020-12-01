<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function coverImage()
    {
        //HasOne so as to return only one record
        return $this->hasOne(UserImage::Class)
            ->orderByDesc('id')
            ->where('location','cover')
            ->withDefault(function ($userImage){
                $userImage->path = 'storage/user-images/default-cover-image.jpg';
            });
    }

    public function profileImage()
    {
        //HasOne so as to return only one record
        return $this->hasOne(UserImage::Class)
            ->orderByDesc('id')
            ->where('location','profile')
            ->withDefault(function ($userImage){
                $userImage->path = 'storage/user-images/default-profile-image.png';
            });
    }

    public function posts()
    {
        return $this->hasMany(Post::Class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::Class,'friends','friend_id','user_id');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes','user_id','post_id');
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }

}
