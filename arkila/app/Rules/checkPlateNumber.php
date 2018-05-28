<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Van;

class checkPlateNumber implements Rule
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
        $vanCount = Van::all()->where('plate_number',strtoupper($value))->count();
        if($vanCount > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The entered plate number already exists';
    }
}
