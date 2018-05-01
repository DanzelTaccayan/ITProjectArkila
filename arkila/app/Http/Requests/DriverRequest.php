<?php

namespace App\Http\Requests;

use App\Rules\checkName;
use App\Rules\checkAddress;
use App\Rules\checkOccupation;
use App\Rules\checkAge;
use App\Rules\checkContactNum;
use App\Rules\checkSSS;
use App\Rules\checkLicense;
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
        switch($this->method())
        {
            case 'POST':
            {

                return [
                    'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
                    'operator' => 'bail|nullable|exists:member,member_id|numeric',
                    'lastName' => 'bail|required|max:30',
                    'firstName' => 'bail|required|max:30',
                    'middleName' => 'bail|nullable|max:30',
                    'contactNumber' => ['bail',new checkContactNum],
                    'address' => ['bail','required','max:100',new checkAddress],
                    'gender' => [
                        'bail',
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'contactPerson' => 'bail|required|max:50',
                    'contactPersonAddress' => ['bail','required','max:100',new checkAddress],
                    'contactPersonContactNumber' => ['bail','required',new checkContactNum],
                    'sss' => ['nullable','bail','unique:member,SSS', new checkSSS],
                    'licenseNo' => ['bail','required',new checkLicense],
                    'licenseExpiryDate' => 'bail|required|date|after:today'
                ];
            }
            case 'PATCH':
            {

                return [
                    'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
                    'operator' => 'bail|nullable|exists:member,member_id|numeric',
                    'lastName' => 'bail|required|max:30',
                    'firstName' => 'bail|required|max:30',
                    'middleName' => 'bail|nullable|max:30',
                    'contactNumber' => ['bail',new checkContactNum],
                    'address' => ['bail','required','max:100',new checkAddress],
                    'provincialAddress' => ['bail','required','max:100',new checkAddress],
                    'birthDate' => ['bail','required','date_format:m/d/Y','after:1/1/1900', new checkAge],
                    'gender' => [
                        'bail',
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'contactPerson' => 'bail|required|max:50', 'nullable',
                    'contactPersonAddress' => ['bail','required','max:100',new checkAddress],
                    'contactPersonContactNumber' => ['bail','required',new checkContactNum],
                    'sss' => ['nullable','bail','unique:member,SSS,'.$this->route('driver')->member_id.',member_id', new checkSSS],
                    'licenseNo' => ['bail','required', new checkLicense],
                    'licenseExpiryDate' => 'bail|required|date|after:today'
                ];
            }
            default:break;
        }
    }    
}

