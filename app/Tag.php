<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function repos()
    {
        return $this->morphedByMany(Repo::class, 'taggable');
    }
}
