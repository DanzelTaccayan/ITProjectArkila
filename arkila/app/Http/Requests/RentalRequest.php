<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\checkName;
use App\Rules\checkTime;
use App\Rules\checkAddress;
use App\Rules\checkContactNum;
use App\Rules\checkPlateNumber;
use App\Rules\checkDriver;
use Carbon\Carbon;
use Illuminate\Http\Request;


class RentalRequest extends FormRequest
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

        $dateCarbon = new Carbon(request('date'));
        $dateFormatted = $dateCarbon->format('m/d/Y');

        if ($dateFormatted !== $dateFormattedNow) {
            return [
                "name" => ['bail',new checkName, 'required', 'max:35'],
                "date" => 'bail|required|date_format:m/d/Y|after_or_equal:today',
                "destination" => ['bail',new checkAddress,'required','max:50'],
                "plateNumber" => [new checkPlateNumber,'required','between:6,9'],
                "driver" => ['numeric',new checkDriver],
                "time" => ['bail',new checkTime, 'required'],
                "days" => "bail|required|numeric|digits_between:1,15|min:1",
                "contactNumber" => ['bail',new checkContactNum],
        
            ];
        } else {
            return [
                "name" => ['bail',new checkName, 'required', 'max:35'],
                "date" =>  'bail|required|date_format:m/d/Y|after_or_equal:today',
                "destination" => ['bail',new checkAddress,'required','max:50'],
                "plateNumber" => [new checkPlateNumber,'required','between:6,9'],
                "driver" => ['numeric', new checkDriver],
                "time" => ['bail',new checkTime, 'required', 'after:' . $timeFormattedNow],
                "days" => "bail|required|numeric|digits_between:1,15|min:1",
                "contactNumber" => ['bail',new checkContactNum],
         
                ];
        }
    }

    public function messages() 
    {
        $dateNow = Carbon::now()->format('h:i A');

        return [
            "name.required" => "Please enter the customers name",
            "name.max" => "Customer name must be less than or equal to 35 characters",

            "date.required" => "Please enter the preffered departure date",
            "date.date_format" => "The preferred date does not match the format mm/dd/yyyy",

            "time.required" => "Please enter the preffered departure time",
            "time.after" => "The time must be a time after ". $dateNow ."",
            "days.required" => "Please enter the number of days",
            "days.numeric" => "Please enter a number in number of days",
            "days.digits_between" => "The days must be between 1-15",
            "days.min" => "The number of days must be atleast 1",
            "model.required" => "Please enter the preffered van model",
            "model.max" => "Van model must be less than or equal to 50 characters",
            "contactNumber.required" => "Please enter the contact number",
            "contactNumber.numeric" => "Please enter a number",
            "contactNumber.digits" => "Contact number must be exactly 10 digits (926XXXXXXX)",

        ];
    }
}
