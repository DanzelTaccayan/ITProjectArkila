<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\checkCurrency;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Destination;


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
        switch($this->method())
        {
            case 'POST':
            {
                if ($request->type == 'Terminal')
                {
                    return [
                        "addTerminal" => 'required|unique:destination,destination_name|max:70',
                        "bookingFee" => 'required|numeric',
                        "sTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "sdTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "numticket" => 'numeric|required|min:1',
                        "numticketDis" => 'numeric|required|min:26',
                        "type" => [
                            'required',
                            Rule::in(['Terminal', 'Route'])
                        ],    
                    ];
                }
                else
                {
                    
                    return [
                        "addTerminal" => 'required|unique:destination,destination_name|max:70',
                        "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "numticket" => 'numeric|required|min:1',
                        "numticketDis" => 'numeric|required|min:26',
                        "dest" => 'required',
                        "dest.*" => 'numeric',
                        "type" => [
                            'required',
                            Rule::in(['Terminal', 'Route'])
                        ],
                        
                    ];   
                }
            }
            case 'PATCH':
            {
                $idRoute = $this->route('route');
                
                if ($request->type == 'Terminal')
                {   
                    return [
                        "bookingFee" => 'required|numeric',
                        "sTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "sdTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "dest" => 'required',
                        "dest.*" => 'numeric',
                        "type" => [
                            'required',
                            Rule::in(['Terminal', 'Route'])
                        ],    
                    ];
                }
                else
                {
                    
                    return [
                        "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
                        "dest" => 'required',
                        "dest.*" => 'numeric',
                        "type" => [
                            'required',
                            Rule::in(['Terminal', 'Route'])
                        ],
                        
                    ];   
                }
            }
        }
    }

    public function messages()
    {
        return [
            'addTerminal.unique' => 'The terminal name has already been taken.',
            'sTripFare.min' => 'The short trip fare regular must be at least 1.',
            'sdTripFare.min' => 'The short trip fare discounted must be at least 1.',
            'dest.required' => 'The destination terminal field is required.',


        ];
    }
}