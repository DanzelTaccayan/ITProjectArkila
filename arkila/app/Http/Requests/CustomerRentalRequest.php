<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Rules\checkSpecialCharacters;
use App\Rules\checkTime;
use Illuminate\Http\Request;
use App\BookingRules;
use App\Rules\checkContactNumber;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRentalRequest extends FormRequest
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
        // $dateNow = Carbon::now();
        // $thisDate = $dateNow->setTimezone('Asia/Manila');

        // $dateFormattedNow = $thisDate->format('m/d/Y');
        // $timeFormattedNow = $thisDate->format('h:i A');


        // $dateCarbon = new Carbon(request('date'));
        // $dateFormatted = $dateCarbon->format('m/d/Y');

        // if($dateFormatted !== $dateFormattedNow){
        //     return [
        //         "rentalDestination" => ["required",new checkAddress,"max:50"],
        //         "contactNumber" => ["required", new checkContactNum],
        //         "numberOfDays" => "required|numeric|digits_between:1,2|min:1",
        //         "date" => "required|date_format:m/d/Y|after_or_equal:today",
        //         "time" => ["required", new checkTime],
        //         "message" => "string|max:300|nullable",
        //     ];
        // }else{
        //     return [
        //         "rentalDestination" => ["required",new checkAddress,"max:50"],
        //         "contactNumber" => ["required", new checkContactNum],
        //         "numberOfDays" => "required|numeric|digits_between:1,2|min:1",
        //         "date" => "required|date_format:m/d/Y|after:" . $timeFormattedNow,
        //         "time" => ["required", new checkTime],
        //         "message" => "string|max:300|nullable",
        //     ];
        // }
        $rule = BookingRules::where('description', 'Rental')->get()->first();
        $limitedDays = $rule->payment_due + $rule->request_expiry;
        $date = Carbon::now()->addDays($limitedDays)->formatLocalized('%d %B %Y');

        if($request->destination == 'other')
        {
            return [
                "date" => 'bail|required|date_format:m/d/Y|after:'.$date,
                "otherDestination" => ['bail','required','max:50'],
                "time" => 'required|date_format:H:i',
                "numberOfDays" => "bail|required|numeric|digits_between:1,15|min:1",
                "contactNumber" => ['bail',new checkContactNumber],
                "message" => "string|max:300|nullable",   
            ];
        }
        else
        {
            return [
                "date" => 'bail|required|date_format:m/d/Y|after:'.$date,
                "destination" => ['bail','required','max:70'], 
                "time" => 'required|date_format:H:i',
                "numberOfDays" => "bail|required|numeric|digits_between:1,15|min:1",
                "contactNumber" => ['bail',new checkContactNumber],
                "message" => "string|max:300|nullable",   
            ];

        }
}


    public function messages()
    {
        $rule = BookingRules::where('description', 'Rental')->get()->first();
        $limitedDays = $rule->payment_due + $rule->request_expiry;
        $date = Carbon::now()->addDays($limitedDays)->formatLocalized('%d %B %Y');
        return [
            "date.after" => "Rentals should be requested ". $limitedDays ." or more days before departure.",
            "date.required" => "Please enter the preffered departure date",
            "date.date_format" => "The preferred date does not match the format mm/dd/yyyy",
            "numberOfDays.required" => "Please enter the number of days",
            "numberOfDays.numeric" => "Please enter a number in number of days",
            "numberOfDays.digits_between" => "The days must be between 1-15",
            "numberOfDays.min" => "The number of days must be atleast 1",
            "message.max" => "The maximum characters is on 300",
        ];
    }
}
