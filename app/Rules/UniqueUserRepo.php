<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueUserRepo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return !in_array($value,auth()->user()->repos->pluck('name')->toArray());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Repositry Name Should Be Unique.';
    }
}
