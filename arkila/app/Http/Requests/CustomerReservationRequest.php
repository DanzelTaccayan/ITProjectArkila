<?php

namespace App\Http\Requests;

use App\Rules\checkTime;
use App\Rules\checkName;
use App\Rules\checkContactNum;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CustomerReservationRequest extends FormRequest
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
                "date" => "bail|required|date_format:m/d/Y|after_or_equal:today",
                "destination" => "bail|required|exists:destination,destination_id",
                "time" => ['bail',new checkTime, 'required'],
                "numberOfSeats" => "bail|required|numeric|digits_between:1,4|min:0|max:15",
                "contactNumber" => ['bail',new checkContactNum],
                "message" => "string|max:300|nullable",
                ];
        } else {
            return [
                "date" => "bail|required|date_format:m/d/Y|after_or_equal:today",
                "destination" => "bail|required|exists:destination,description",
                "time" => ['bail',new checkTime, 'required', 'after:' . $timeFormattedNow],
                "numberOfSeats" => "bail|required|numeric|digits_between:1,4|min:1|max:15",
                "contactNumber" => ['bail',new checkContactNum],
                "message" => "string|max:300|nullable",
            ];
        }
    }

    public function messages()
    {
        $dateNow = Carbon::now();
        $thisDate = $dateNow->setTimezone('Asia/Manila')->format('h:i A');

        return [
            "destination.exists" => "Invalid input for destinations",
            "date.required" => "Please enter the preffered departure date",
            "date.date_format" => "Please enter a valid date format (mm/dd/yyyy)",
            "time.required" => "Please enter the preffered departure time",
            "time.after" => "The time must be a time after ". $thisDate ."",
            "destination.required" => "The destination field is required",
            "numberOfSeats.required" => "Please enter the number of seat for the reservation",
            "numberOfSeats.numeric" => "The seat must be a number",
            "numberOfSeats.digits_between" => "Please enter a number of seat between 1-15",
            "message.max" => "The maximum characters is on 300",
        ];
    }
}
