<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkName implements Rule
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
        return (preg_match('/^[a-zA-Z]$|^[a-zA-Z][a-zA-Z\s-]*[a-zA-Z]$/',$value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid name entered. The :attribute field can only consist of alphabetic characters, spaces or dashes and it must be a valid name ';
    }
}
