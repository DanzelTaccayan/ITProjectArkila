<?php

namespace App\Http\Requests;

use App\Rules\checkAddress;
use App\Rules\checkName;
use App\Rules\checkOccupation;
use App\Rules\checkAge;
use App\Rules\checkContactNum;
use App\Rules\checkSSS;
use App\Rules\checkLicense;
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

        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
                    'lastName' => ['bail','required',new checkName,'max:30'],
                    'firstName' => ['bail','required',new checkName,'max:30'],
                    'middleName' => ['bail','nullable',new checkName,'max:30'],
                    'contactNumber' => ['bail', new checkContactNum],
                    'address' => ['bail','required','max:100',new checkAddress],
                    'provincialAddress' => ['bail','required','max:100',new checkAddress],
                    'birthDate' => ['bail','required','date_format:m/d/Y','after:1/1/1900', new checkAge],
                    'birthPlace' => ['bail','regex:/[a-zA-Z ]$|^[a-zA-Z][a-zA-Z\s-,]*[a-zA-Z ]$/','required','max:35'],
                    'gender' => [
                        'bail',
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'citizenship' => 'bail|regex:/[a-zA-Z ]$/|required|max:25',
                    'civilStatus' => [
                        'bail',
                        'required',
                        Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                    ],
                    'nameOfSpouse' => ['bail','required_if:civilStatus,Married','required_with:spouseBirthDate','max:40', 'nullable',new checkName],
                    'spouseBirthDate' => ['bail','required_with:nameOfSpouse','nullable','date','before:today',new checkAge],
                    'fathersName' => ['bail','required_with:fatherOccupation','max:50', 'nullable',new checkName],
                    'fatherOccupation' => ['bail','required_with:fathersName','max:30', 'nullable', new checkOccupation],
                    'mothersName' => ['bail','required_with:motherOccupation','max:50', 'nullable',new checkName],
                    'motherOccupation' => ['bail','required_with:mothersName','max:30', 'nullable', new checkOccupation],
                    'contactPerson' => ['bail','required','max:50', 'nullable', new checkName],
                    'contactPersonAddress' => ['bail','required','max:100',new checkAddress],
                    'contactPersonContactNumber' => ['bail','required', new checkContactNum],
                    'sss' => ['nullable','bail','unique:member,SSS',new checkSSS],
                    'licenseNo' => ['bail','required_with:licenseExpiryDate','nullable',new checkLicense],
                    'licenseExpiryDate' => 'bail|required_with:licenseNo|nullable|date|after:today',
                    'children.*' => ['bail','required_with:childrenBDay.*','distinct', 'nullable', new checkName, 'max:40'],
                    'childrenBDay.*' => 'bail|required_with:children.*|nullable|date|before:tomorrow|after:'.$this->birthDate
                ];
            }
            case 'PATCH':
            {
//                dd($this->all());
                    return [
                        'profilePicture' => 'bail|nullable|mimes:jpeg,jpg,png|max:3000',
                        'lastName' => ['bail','required',new checkName,'max:30'],
                        'firstName' => ['bail','required',new checkName,'max:30'],
                        'middleName' => ['bail','nullable',new checkName,'max:30'],
                        'contactNumber' => ['bail',new checkContactNum],
                        'address' => ['bail','required','max:100',new checkAddress],
                        'provincialAddress' => ['bail','required','max:100',new checkAddress],
                        'birthDate' => ['bail','required','date_format:m/d/Y','after:1/1/1900', new checkAge],
                        'birthPlace' => ['bail','regex: /[a-zA-Z ]$|^[a-zA-Z][a-zA-Z\s-,]*[a-zA-Z ]$/','required','max:35'],
                        'gender' => [
                            'bail',
                            'required',
                            Rule::in(['Male', 'Female'])
                        ],
                        'citizenship' => 'bail|regex:/[a-zA-Z ]$/|required|max:25',
                        'civilStatus' => [
                            'bail',
                            'required',
                            Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                        ],
                        'nameOfSpouse' => ['bail','required_if:civilStatus,Married','required_with:spouseBirthDate','max:40', 'nullable', new checkName],
                        'spouseBirthDate' => ['bail','required_with:nameOfSpouse','nullable','date','before:today',new checkAge],
                        'fathersName' => ['bail','required_with:fatherOccupation','max:50', 'nullable', new checkName],
                        'fatherOccupation' => ['bail','required_with:fathersName','max:30', 'nullable', new checkOccupation],
                        'mothersName' => ['bail','required_with:motherOccupation','max:50', 'nullable',new checkName],
                        'motherOccupation' => ['bail','required_with:mothersName','max:30', 'nullable', new checkOccupation],
                        'contactPerson' => ['bail','required','max:50', 'nullable', new checkName],
                        'contactPersonAddress' => ['bail','required','max:100',new checkAddress],
                        'contactPersonContactNumber' => ['bail','required',new checkContactNum],
                        'sss' => ['nullable', 'bail','unique:member,SSS,'.$this->route('operator')->member_id.',member_id',new checkSSS],
                        'licenseNo' => ['bail','required_with:licenseExpiryDate','nullable',new checkLicense],
                        'licenseExpiryDate' => 'bail|required_with:licenseNo|nullable|date|after:today',
                        'children.*' => ['bail','required_with:childrenBDay.*','distinct', 'nullable', new checkName,'max:50'],
                        'childrenBDay.*' => 'bail|required_with:children.*|nullable|date|before:tomorrow|after:'.$this->birthDate
                    ];

            }
            default:break;
        }
    }
}
