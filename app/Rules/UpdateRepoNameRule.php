<?php

namespace App\Rules;

use App\Repo;
use Illuminate\Contracts\Validation\Rule;

class UpdateRepoNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
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
        $names = auth()->user()->repos;
        $names = $names->except($this->repo->id)->pluck('name')->toArray();
        return !in_array($value,$names);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
