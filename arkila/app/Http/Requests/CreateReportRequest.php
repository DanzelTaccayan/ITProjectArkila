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
        $member = Member::where('user_id', Auth::id())->first();
        $member_van = $member->van->first();

        $rules = [
          "dateDeparted" => "required|date_format:m/d/Y",
          "timeDeparted" => [new checkTime, "required"],
          "numberOfDiscount" => "present|array",
          "qty" => "present|array",
          //"numberOfDiscount.*" => "nullable|numeric|min:1",
          "totalPassengers" => "numeric|min:1|max:".$member_van->seating_capacity."|required",
          "totalBookingFee" => ['required', new checkCurrency],
        ];

        $qtyCounter = 0;
        $qtySum = 0;
        $qty = $this->request->get('qty');
        foreach($qty as $key => $value){
          $qtySum = $qtySum + $value;
          if($value === null){
            $qtyCounter++;
          }
        }

        if($this->request->get('totalPassengers') > $qtySum){
          $rules['totalPassengers'] = "numeric|min:1|max:".$qtySum."|required";
        }

         if($qtyCounter == 0){
           // $rules['qty.*'] = "numeric";
           $rules['qty.*'] = "min:1";
           // $rules['totalPassengers'] = 'numeric|min:1|max:'.$member_van->seating_capacity.'|required_with:qty.*,';
           // $rules['totalBookingFee'] = ['required_with:qty.*', new checkCurrency];
         }

         if($this->request->get('totalPassengers') > $qtySum){
           $rules['qty.*'] = "min:1";
         }

         if($this->request->get('numberOfDiscount') !== null){
           foreach($this->request->get('numberOfDiscount') as $key => $value){
             $rules['numberOfDiscount.'.$key] = 'nullable|numeric|min:1';
           }
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
        "totalBookingFee.required" => "Please enter the booking fee of your trip",
        "numberOfDiscount.array" => "Cannot proceed with unless you refresh",
      ];

      $qtyCounter = 0;
      $qtySum = 0;
      $qty = $this->request->get('qty');
      foreach($qty as $key => $value){
        $qtySum = $qtySum + $value;
        if($value === null){
          $qtyCounter++;
        }
      }

      if($qtyCounter == 0){
        $messages['qty.min'] = "Cannot be empty";
      }

      if($this->request->get('totalPassengers') > $qtySum){
        $messages['totalPassengers.max'] = "Total number of passengers cannot be more than the sum of passengers per destination entered";
      }

      if($this->request->get('numberOfDiscount') !== null){
        foreach($this->request->get('numberOfDiscount') as $key => $value){
          if($value < 0 || $value == 0 ){
              $messages['numberOfDiscount.'.$key.'.min'] = "The number of discount must greater than 0";
              break;
          }else if(!(is_numeric($value))){
              $messages['numberOfDiscount.'.$key.'.numeric'] = "The number of discount must be numeric";
              break;
          }
        }
      }

      return $messages;
    }
}