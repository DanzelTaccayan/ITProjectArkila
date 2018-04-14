<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkAddress implements Rule
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

        return (preg_match('/([A-Za-z\d ]|[\d #])[A-Za-z\d .,-]*[A-Za-z\d ]$/',$value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter a valid address on the :attribute field';
    }
}
