<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use App\Member;

class CreateReportRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
          "dateDeparted" => "required|date_format:m/d/Y",
          "timeDeparted" => [new checkTime, "required"],
          "totalPassengers" => "numeric|min:1|max:18|required",
          "numPassMain" => "numeric|required_without_all:numPassST",
          "numPassST" => "numeric|required_without_all:numPassMain",
          "origin" => "required|exists:destination,destination_id"
        ];

       
         //1
        if((($this->request->get('numPassMain') !== null || $this->request->get('numPassMain') !== 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') !== null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') !== null || $this->request->get('numDisST') != 0))){
          $rules['numDisMain'] = "nullable";
        //2.
        }else if((($this->request->get('numPassMain') !== null || $this->request->get('numPassMain') !== 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') !== null || $this->request->get('numDisST') != 0))){
          $rules['numDisMain'] = "nullable";
          $rules['numPassST'] = "nullable";
        //3.
        }else if((($this->request->get('numPassMain') !== null || $this->request->get('numPassMain') !== 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numDisMain'] = "nullable";
          $rules['numPassST'] = "nullable";
          $rules['numDisST'] = "nullable";
        //4.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') !== null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') !== null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') !== null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
        //5.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') !== null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') !== null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numDisMain'] = "nullable";
        //6.   
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') !== null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numDisMain'] = "nullable";
          $rules['numPassST'] = "nullable";
        }
        return $rules;
    }

    public function messages()
    {
      $messages = [
        "dateDeparted.required" => "Please enter the date of departure",
        "dateDeparted.date_format" => "Please enter the correct format for the date of departure: mm/dd/yyyy",
        "timeDeparted.required" => "Please enter time of departure",
        "totalPassengers.numeric" => "Please enter a valid number for the total number of passengers",
        "totalPassengers.required" => "Please enter the number of passengers per destination",
        "totalPassengers.max" => "Number of passengers cannot exceed 18 which is the maximum number of passengers in a van",
        "origin.exists" => "Your origin terminal is not valid",
        "numDisMain.numeric" => "Discouted passengers for the main terminal must be numeric",
        "numDisMain.min" => "The number of discounted passengers must at least be 1",
        "numDisST.numeric" => "Discouted passengers for short trips must be numeric",
        "numDisST.min" => "The number of discounted passengers must at least be 1",
      ];

      return $messages;
    }
}
