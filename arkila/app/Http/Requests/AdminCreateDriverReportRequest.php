<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\checkPlateNumber;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use App\Destination;
use App\Member;
use App\Van;


class AdminCreateDriverReportRequest extends FormRequest
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
        "driverAndOperator" => "required|exists:member,member_id",
        "dateDeparted" => "required|date_format:m/d/Y",
        "timeDeparted" => [new checkTime, "required"],
        // "qty" => "present|array",
        "totalPassengers" => "numeric|min:1|max:18|required",
      ];

        $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first()->destination_id;

        if($this->request->get('orgId') == $mainTerminal){

          // $rules["origin"] = "required|exists:destination,destination_id";

          $totalPass = $this->request->get('totalPassengers');
          $qtyCounter = 0;
          $qtySum = 0;
          $qty = $this->request->get('qty');
          foreach($qty as $key => $value){
            $qtySum = $qtySum + $value;
            if($value === null){
              $qtyCounter++;
            }
          }

          if($totalPass > $qtySum){
            $rules['qty'] = "numeric|min:1|max:".$totalPass."|required";
          }

          if(($qtyCounter == count($qty)) && ($this->request->get('totalPassengers') !== null)){
            $rules['qty'] = "min:1";
          }

          if($totalPass != $qtySum){
            $rules['totalPassengers'] = "in:" . $qtySum;
          }

        }else{

          $rules = [
            "numPassMain" => "numeric|min:1|max:18|required_without_all:numPassST",
            "numPassST" => "numeric|min:1|max:18|required_without_all:numPassMain",
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
        }

        return $rules;
    }

    public function messages()
    {
      $messages = [
        "driverAndOperator.required" => "Please select a driver",
        "driverAndOperator.exists" => "Driver does not exists",
        "dateDeparted.required" => "Please enter the date of departure",
        "dateDeparted.date_format" => "Please enter the correct format for the date of departure: mm/dd/yyyy",
        "timeDeparted.required" => "Please enter time of departure",
        "totalPassengers.numeric" => "Please enter a valid number for the total number of passengers",
        "totalPassengers.required" => "Please enter the number of passengers per destination",
        "totalPassengers.max" => "Please enter the number of passengers per destination",
      ];

      $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first()->destination_id;
      if($this->request->get('origin') == $mainTerminal){

        $messages = [
          "origin.required" => "Please choose a destination terminal",
          "origin.exists" => "Your destination terminal is not valid",
        ];

        $totalPass = $this->request->get('totalPassengers');
        $qtyCounter = 0;
        $qtySum = 0;
        $qty = $this->request->get('qty');
        foreach($qty as $key => $value){
          $qtySum = $qtySum + $value;
          if($value === null){
            $qtyCounter++;
          }
        }

        if($totalPass > $qtySum){
          $messages["qty.max"] = "The number of passengers per destination should be equal to the total number of passengers";
        }
        if(($qtyCounter == count($qty)) && ($this->request->get('totalPassengers') !== null)){
          $messages["qty.min"] = "The number of passengers per destination should be equal to the total number of passengers";
        }

        if($totalPass != $qtySum){
          $messages["totalPassengers"] = "The total number of passengers must be equal to the sum of passengers per destination";
        }
      }else{
        $messages = [
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

      }
      return $messages;
    }
}
