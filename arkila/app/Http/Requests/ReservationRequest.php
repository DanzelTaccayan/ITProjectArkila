<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Reservation;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use App\Rules\checkName;
use App\Rules\checkContactNum;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReservationRequest extends FormRequest
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
        
            return [
                "date" => "bail|required|date_format:m/d/Y|after:today",
                "destination" => "bail|required",
                "time" => 'required|date_format:H:i',
                "slot" => "bail|required|numeric|min:1|max:30",
                ];
    }

    public function messages() 
    {
        $dateNow = Carbon::now();
        $thisDate = $dateNow->setTimezone('Asia/Manila')->formatLocalized('%B %d,  %Y');


        return [
            "date.required" => "Please enter the preffered departure date",
            "date.date_format" => "Please enter a valid date format (mm/dd/yyyy)",
            "date.after" => "Please enter a date after ". $thisDate,
            "time.required" => "Please enter the preffered departure time",
            "destination.required" => "The destination field is required",
            "slot.required" => "Please enter the number of seat for the reservation",
            "slot.numeric" => "The seat must be a number",
            "slot.min" => "Please enter a number of slots greater than 0",

        ];
    }
}
