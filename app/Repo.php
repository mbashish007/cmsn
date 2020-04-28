<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;



class Repo extends Model
{
    use Likeable;
    
    protected $guarded = [];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function user() {
        return $this->belongsTo(User::class) ;
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Check If Repo has Tag.
     *
     * 
     * @return bool
     */

     
     
    public function hasTag($tagid){
        return in_array($tagid,$this->tags->pluck('id')->toArray());
    }

    
}
