<?php

namespace App\Http\Requests;

use App\Rules\checkSpecialCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class OperatorRequest extends FormRequest
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
        if($this->method() === "POST") {
            $sss = ['sss' => 'nullable, bail, unique:member, SSS'];

        } else {
            $sss =  ['sss' => 'nullable, bail, unique:member,SSS,'.$this->route('operator')->member_id.',member_id'];
        }
        return [
            'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
            'lastName' => ['bail','required','max:25',new checkSpecialCharacters],
            'firstName' => ['bail','required','max:25',new checkSpecialCharacters],
            'middleName' => ['bail','nullable','max:25',new checkSpecialCharacters],
            'contactNumber' => 'bail|numeric|required',
            'address' => ['bail','required','max:70',new checkSpecialCharacters],
            'provincialAddress' => ['bail','required','max:70',new checkSpecialCharacters],
            'gender' => [
                'bail',
                'required',
                Rule::in(['Male', 'Female'])
            ],
            'contactPerson' => ['bail','required', 'max:75',new checkName],
            'contactPersonAddress' => ['bail','required','max:70',new checkName],
            'contactPersonContactNumber' => 'bail|required|numeric',
            'licenseNo' => 'bail|required',
            'licenseExpiryDate' => 'bail|required|date|after:today',
            'sss' => 'nullable| bail| unique:member,SSS,'.$this->route('operator')->member_id.',member_id'
        ];
    }
}
