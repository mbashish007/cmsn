<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    /**
     * create images for given Post
     * 
     * @param array images
     * 
     * @return void
     */
    public function attachImages(array $post_images){
        foreach($post_images as $post_image){
            $path = $post_image->store('images');
            $this->images()->create([
                'image' => $path,
            ]);
        }
    }

    public function updateImages(array $post_images){
        if($this->images->count() > 0){
            $this->deleteImages();
            }
    $this->attachImages($post_images);
    }

    public function deleteImages(){
        foreach($this->images as $image){
            Storage::delete($image->image);
            $image->delete();
        }
    }

    public function deletePost(){
        if($this->images->count() > 0){
            $this->deleteImages();
        }
        $this->delete();
    }
    
}
