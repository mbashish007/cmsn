<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function repo() {
        return $this->belongsTO(Repo::class);
    }

    public function deleteFile() {
        Storage::delete($this->file);
    }

    public function Ext() {
        $arr = explode('.',$this->file);
        return end($arr);
    }
}
