<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Destination;

class checkDestinationUniqueness implements Rule
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
        $terminal = request('addDestinationTerminal');
        if(isset($terminal))
        {
            if($destination = Destination::where('description',$value)->first())
            {
                if($destination->terminal_id != request('addDestinationTerminal'))
                {
                        return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The destination already exist in this terminal.';
    }
}
