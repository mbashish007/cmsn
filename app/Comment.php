<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Comment extends Model
{
    use Likeable;
    protected $guarded = [];
    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
