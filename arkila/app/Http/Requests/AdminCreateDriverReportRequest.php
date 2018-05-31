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
            if($value == 0 || $value == null){
              $qtyCounter++;
            }
          }

          $desc = $this->request->get('disqty');
          $descCounter = 0;
          $descSum = 0;
          foreach($desc as $key => $value){
            $descSum = $descSum + $value;
            if($value == 0 || $value == null){
              $descCounter = 0;
            }
          }

          $totalSum = $qtySum + $descSum;

          if($totalPass > $totalSum){
            $rules['qty'] = "numeric|min:1|max:".$totalPass."|required";
          }

          if(($qtyCounter == count($qty) && $descCounter == count($desc)) 
          && ($this->request->get('totalPassengers') !== null || $this->request->get('totalPassengers') != 0)){
            $rules['qty'] = "min:1";
          }

          if($totalPass != $totalSum){
            $rules['totalPassengers'] = "in:" . $qtySum;
          }

        }else{

          $rules = [
            "numPassMain" => "numeric|required_without_all:numPassST",
            "numPassST" => "numeric|required_without_all:numPassMain",
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

        $desc = $this->request->get('disqty');
          $descCounter = 0;
          $descSum = 0;
          foreach($desc as $key => $value){
            $descSum = $descSum + $value;
            if($value == 0 || $value == null){
              $descCounter = 0;
            }
          }
        
        $totalSum = $qtySum + $descSum;  
          
        if($totalPass > $totalSum){
          $messages["qty.max"] = "The number of passengers per destination should be equal to the total number of passengers";
        }
        if(($qtyCounter == count($qty) && $descCounter == count($desc))){
          $messages["qty.min"] = "The number of passengers per destination should be equal to the total number of passengers";
        }

        if($totalPass != $totalSum){
          $messages["totalPassengers"] = "The total number of passengers must be equal to the sum of passengers per destination";
        }
      }else{
        $messages = [
          "numDisMain.numeric" => "Discouted passengers for the main terminal must be numeric",
          "numDisMain.min" => "The number of discounted passengers must at least be 1",
          "numDisST.numeric" => "Discouted passengers for short trips must be numeric",
          "numDisST.min" => "The number of discounted passengers must at least be 1",
        ];

      }
      return $messages;
    }
}
