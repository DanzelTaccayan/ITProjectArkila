<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkOccupation implements Rule
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
        return (preg_match('/^([a-zA-Z- ()])+([a-zA-Z])+$/',$value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The entered occupation is invalid, it must not contain any numbers.';
    }
}
