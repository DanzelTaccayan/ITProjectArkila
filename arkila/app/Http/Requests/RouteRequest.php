<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\checkCurrency;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class RouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        if ($request->destType == 'Terminal')
        {

            return [
                "addTerminal" => ['required', 'max:70'],
                "bookingFee" => 'required|numeric',
                "sTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "sdTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "numticket" => 'required|numeric|digits_between:1,1000',
                "destType" => [
                    'required',
                    Rule::in(['Terminal', 'Route'])
                ],    
            ];
        }
        else
        {
            
            return [
                "addTerminal" => ['required', 'max:70'],
                "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                "numticket" => 'required|numeric|digits_between:1,1000',
                "dest" => 'required',
                "dest.*" => 'numeric',
                "destType" => [
                    'required',
                    Rule::in(['Terminal', 'Route'])
                ],
                
            ];
            
        }
    }
}
