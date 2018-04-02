<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Rules\checkName;
use App\Rules\checkTime;
use Illuminate\Http\Request;
use App\Rules\checkContactNum;
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
        $dateNow = Carbon::now();
        $thisDate = $dateNow->setTimezone('Asia/Manila');
        
        $dateFormattedNow = $thisDate->format('m/d/Y');
        $timeFormattedNow = $thisDate->format('h:i A');
        
        $dateToday = $request->date;
        $mm = substr($dateToday, '0', 2);
        $dd = substr($dateToday, '3', 2);
        $yy = substr($dateToday, '6', 4);
        if ($mm == 'mm' || $dd == 'dd' || $yy == 'yyyy' || $dateToday == null) {
            return [
                "date" => 'bail|required|date_format:m/d/Y|after_or_equal:today',
            ];
        }
        $dateCarbon = new Carbon(request('date'));
        $dateFormatted = $dateCarbon->format('m/d/Y');

        if($dateFormatted !== $dateFormattedNow){
            return [
                "rentalDestination" => "bail|required|regex:/^[,\pL\s\-]+$/u|max:50",
                "contactNumber" => ['bail',new checkContactNum],
                "numberOfDays" => "bail|required|numeric|digits_between:1,2|min:1",
                "date" => "bail|required|date_format:m/d/Y|after_or_equal:today",
                "time" => ["bail",new checkTime, "required"],
                "message" => "string|max:300|nullable",
            ]; 
        }else{
            return [
                "rentalDestination" => "bail|required|regex:/^[,\pL\s\-]+$/u|max:50",
                "contactNumber" => ['bail',new checkContactNum],
                "numberOfDays" => "bail|required|numeric|digits_between:1,2|min:1",
                "date" => "bail|required|date_format:m/d/Y|after:" . $timeFormattedNow,
                "time" => ["bail",new checkTime, "required"],
                "message" => "string|max:300|nullable",
            ];
        }   
    }

    public function messages()
    {
        $dateNow = Carbon::now();
        $thisDate = $dateNow->setTimezone('Asia/Manila')->format('m/d/Y');
        return [
            "date.after" => "The date must be after or equal" . $thisDate . "",
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
