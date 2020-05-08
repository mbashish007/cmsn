<?php

namespace App\Rules;

use App\Post;
use Illuminate\Contracts\Validation\Rule;

class UpdatePostTitle implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $titles = auth()->user()->posts;
        $titles = $titles->except($this->post->id)->pluck('name')->toArray();
        return !in_array($value,$titles);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Title Has To Be Unique';
    }
}
