<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use App\Member;
use Carbon\Carbon;

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

      $now = Carbon::now()->formatLocalized('%B %d %Y');
        $rules = [
          "dateDeparted" => "required|date_format:m/d/Y|before_or_equal:" .$now,
          "timeDeparted" => 'required|date_format:H:i|',
          "totalPassengers" => "required|numeric|min:1|max:18",
          "numPassMain" => "required_without_all:numPassST,numDisMain,numDisST|numeric|min:1",
          "numPassST" => "required_without_all:numPassMain,numDisMain,numDisST|numeric|min:1",
          "numDisMain" => "required_without_all:numPassMain,numPassST,numDisST|numeric|min:1",
          "numDisST" => "required_without_all:numPassMain,numPassST,numDisST|numeric|min:1",
          "origin" => "required|exists:destination,destination_id"
        ];


         //1
        if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numDisMain'] = "nullable";
        //2.
        }else if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numDisMain'] = "nullable";
          $rules['numDisST'] = "nullable";
        //3.
        }else if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numDisMain'] = "nullable";
          $rules['numPassST'] = "nullable";
          $rules['numDisST'] = "nullable";
        //4.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
        //5.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numDisMain'] = "nullable";
        //6.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numDisMain'] = "nullable";
          $rules['numPassST'] = "nullable";
        //7.
        }else if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numDisST'] = "nullable";
        //8.
        }else if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numPassST'] = "nullable";
          $rules['numDisST'] = "nullable";
        //9.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numPassST'] = "nullable";
          $rules['numDisST'] = "nullable";
          $rules['numPassMain'] = "nullable";
        //10.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
        //11.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numPassST'] = "nullable";
        //12.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numPassST'] = "nullable";
          $rules['numDisST'] = "nullable";
        //13.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') != null || $this->request->get('numDisMain') != 0))
        && (($this->request->get('numPassST') != null || $this->request->get('numPassST') != 0) && ($this->request->get('numDisST') == null || $this->request->get('numDisST') == 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numDisST'] = "nullable";
        //14.
        }else if((($this->request->get('numPassMain') != null || $this->request->get('numPassMain') != 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassST'] = "nullable";
          $rules['numDisMain'] = "nullable";
        //15.
        }else if((($this->request->get('numPassMain') == null || $this->request->get('numPassMain') == 0) && ($this->request->get('numDisMain') == null || $this->request->get('numDisMain') == 0))
        && (($this->request->get('numPassST') == null || $this->request->get('numPassST') == 0) && ($this->request->get('numDisST') != null || $this->request->get('numDisST') != 0))){
          $rules['numPassMain'] = "nullable";
          $rules['numPassST'] = "nullable";
          $rules['numDisMain'] = "nullable";
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
        "numPassMain.numeric" => "Main terminal passengers must be numeric",
        "numPassMain.min" => "The number of main terminal passengers must at least be 1",
        "numPassST.numeric" => "Short trip passengers must be numeric",
        "numPassST.min" => "The number of short trip passengers must at least be 1",
        "numDisMain.numeric" => "Discouted passengers for the main terminal must be numeric",
        "numDisMain.min" => "The number of discounted main terminal passengers must at least be 1",
        "numDisST.numeric" => "Discouted passengers for short trips must be numeric",
        "numDisST.min" => "The number of discounted passengers must at least be 1",
      ];

      return $messages;
    }
}
