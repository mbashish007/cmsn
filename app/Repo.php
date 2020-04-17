<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Repo extends Model
{
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

    
}
