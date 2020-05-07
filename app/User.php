<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelLike\Traits\Liker;

class User extends Authenticatable
{
    use Liker,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function repos() {
        return $this->hasMany(Repo::class);
    } 

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function files() {
        return $this->hasManyThrough(File::class,Repo::class);
    }

    /**
     * Get the user's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function profile_pic(){
        $profile = 'storage/';
        if($this->image){
            $profile = $profile.$this->image->image;
        }
        else {
            $profile = $profile.'images/blank-profile-picture-973460_640.png';
        }

        return $profile;
    }
}
