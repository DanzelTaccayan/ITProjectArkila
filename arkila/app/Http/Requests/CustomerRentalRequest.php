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


        $dateCarbon = new Carbon(request('date'));
        $dateFormatted = $dateCarbon->format('m/d/Y');

        if($dateFormatted !== $dateFormattedNow){
            return [
            	"van_model" => "required|exists:van_model,description",
                "rentalDestination" => "required|regex:/^[,\pL\s\-]+$/u|max:50",
                "contactNumber" => ["required", new checkContactNum],
                "numberOfDays" => "required|numeric|digits_between:1,2|min:1",
                "date" => "required|date_format:m/d/Y|after_or_equal:today",
                "time" => ["required", new checkTime],
                "message" => "string|max:300|nullable",
            ];
        }else{
            return [
            	"van_model" => "required|exists:van_model,description",
                "rentalDestination" => "required|regex:/^[,\pL\s\-]+$/u|max:50",
                "contactNumber" => ["required", new checkContactNum],
                "numberOfDays" => "required|numeric|digits_between:1,2|min:1",
                "date" => "required|date_format:m/d/Y|after:" . $timeFormattedNow,
                "time" => ["required", new checkTime],
                "message" => "string|max:300|nullable",
            ];
        }
    }

    public function messages()
    {
        $dateNow = Carbon::now();
        $thisDate = $dateNow->setTimezone('Asia/Manila')->format('m/d/Y');
        return [
        	"van_model.exists" => "The van model does not exist",
            "date.after" => "The date must be after or equal " . $thisDate . "",
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
