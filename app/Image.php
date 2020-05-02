<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function delete_img(){
        Storage::delete($this->image);
    }
}
