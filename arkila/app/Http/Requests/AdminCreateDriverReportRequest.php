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
use Carbon\Carbon;


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
      $now = Carbon::now()->formatLocalized('%B %d %Y');
      $rules = [
        "driverAndOperator" => "required|exists:member,member_id",
        "dateDeparted" => "required|date_format:m/d/Y|before_or_equal: ".$now,
        "timeDeparted" => 'required|date_format:H:i|',
        // "qty" => "present|array",
        "totalPassengers" => "required|numeric|min:1|max:18",
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

          if(($qtyCounter == array_sum($qty) && $descCounter == array_sum($desc))
          && ($this->request->get('totalPassengers') !== null || $this->request->get('totalPassengers') != 0)){
            $rules['qty'] = "min:1";
          }

          // if((array_sum($qty) == 0 ||  && array_sum($desc) == 0)){
          //
          // }

          if($totalPass != $totalSum){
            $rules['totalPassengers'] = "in:" . $qtySum;
          }

        }else{

          $rules = [
            "numPassMain" => "required_without_all:numPassST,numDisMain,numDisST|numeric|min:1",
            "numPassST" => "required_without_all:numPassMain,numDisMain,numDisST|numeric|min:1",
            "numDisMain" => "required_without_all:numPassMain,numPassST,numDisST|numeric|min:1",
            "numDisST" => "required_without_all:numPassMain,numPassST,numDisMain|numeric|min:1",
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
          "numPassMain.numeric" => "Main terminal passengers must be numeric",
          "numPassMain.min" => "The number of main terminal passengers must at least be 1",
          "numPassST.numeric" => "Short trip passengers must be numeric",
          "numPassST.min" => "The number of short trip passengers must at least be 1",
          "numDisMain.numeric" => "Discouted passengers for the main terminal must be numeric",
          "numDisMain.min" => "The number of discounted main terminal passengers must at least be 1",
          "numDisST.numeric" => "Discouted passengers for short trips must be numeric",
          "numDisST.min" => "The number of discounted passengers must at least be 1",
        ];

        // if(($this->request->get('numPassMain') == 0 || $this->request->get('numPassMain') == null)
        // && ($this->request->get('numPassST') == 0 || $this->request->get('numPassST') == null)
        // && ($this->request->get('numDisMain') == 0 || $this->request->get('numDisMain') == null)
        // && ($this->request->get('numDisST') == 0 || $this->request->get('numDisST') == null)
        // && ($this->request->get('totalPassengers') == 0 || $this->request->get('totalPassengers') == null)){
        //   $messages['totalPassengers.min'] = "The number of passengers must at least be 1";
        // }

      }
      return $messages;
    }
}
