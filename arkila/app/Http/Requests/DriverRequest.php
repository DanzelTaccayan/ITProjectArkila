<?php

namespace App\Http\Requests;

use App\Rules\checkContactNumber;
use App\Rules\checkSpecialCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DriverRequest extends FormRequest
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
        return [
            'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
            'lastName' => ['bail','required','max:25',new checkSpecialCharacters],
            'firstName' => ['bail','required','max:25',new checkSpecialCharacters],
            'middleName' => ['bail','nullable','max:25',new checkSpecialCharacters],
            'contactNumber' => ['bail','required', new checkContactNumber],
            'address' => ['bail','required','max:70',new checkSpecialCharacters],
            'provincialAddress' => ['bail','required','max:70',new checkSpecialCharacters],
            'gender' => [
                'bail',
                'required',
                Rule::in(['Male', 'Female'])
            ],
            'contactPerson' => ['bail','required', 'max:75',new checkSpecialCharacters],
            'contactPersonAddress' => ['bail','required','max:70',new checkSpecialCharacters],
            'contactPersonContactNumber' => ['bail','required', new checkContactNumber],
            'licenseNo' => 'bail|required',
            'licenseExpiryDate' => 'bail|required',
            'sss' => 'nullable'
        ];
    }
}
