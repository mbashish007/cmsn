<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Post extends Model
{

    use Likeable;
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class) ;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Check If Post has Tag.
     *
     * 
     * @return bool
     */
    public function hasTag($tagid){
        return in_array($tagid,$this->tags->pluck('id')->toArray());
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
