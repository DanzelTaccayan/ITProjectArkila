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
          "numPassMain" => "numeric|min:1|max:18|required_without_all:numPassST",
          "numPassST" => "numeric|min:1|max:18|required_without_all:numPassMain",
          "origin" => "required|exists:destination,destination_id"
        ];

        if($this->request->get('numDisMain') > $this->request->get('numPassMain')){
          $rules['numDisMain'] = "nullable|numeric|min:1|max:numPassMain";
        }else{
          $rules['numDisMain'] = "nullable|numeric|min:1|max:18";
        }

        if($this->request->get('numDisST') > $this->request->get('numPassST')){
          $rules['numDisST'] = "nullable|numeric|min:1|max:numPassST";
        }else{
          $rules['numDisST'] = "nullable|numeric|min:1|max:18";
        }

        if($this->request->get('numPassMain') == null){
          $rules['numPassMain'] = "nullable";
        }else if($this->request->get('numPassST') == null){
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

      if($this->request->get('numDisMain') > $this->request->get('numPassMain')){
        $messages['numDisMain.max'] = "The number of discounted passengers cannot be more than the number of passengers";
      }else{
        $messages['numDisMain.max'] = "The number of discounted passengers cannot be more than 18";
      }

      if($this->request->get('numDisST') > $this->request->get('numPassST')){
        $messages['numDisST.max'] = "The number of discounted passengers cannot be more than the number of passengers";
      }else{
        $messages['numDisST.max'] = "The number of discounted passengers cannot be more than the number of passengers";
      }

      // if($this->request->get('numPassMain') == null){
      //   $messages['numPassST.min'] = "";
      // }else if($this->request->get('numPassST') == null){
      //   $messages['numPassMain.min'] = "";
      // }

      return $messages;
    }
}
