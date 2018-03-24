<?php

namespace App\Http\Requests;

use App\Rules\checkName;
use App\Rules\checkOccupation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\checkAge;
use App\Rules\checkContactNum;

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

                    'lastName' => ['bail','required',new checkName,'max:25'],
                    'firstName' => ['bail','required',new checkName,'max:25'],
                    'middleName' => ['bail','required',new checkName,'max:25'],
                    'contactNumber' => ['bail', new checkContactNum],
                    'address' => 'bail|required|max:100',
                    'provincialAddress' => 'bail|required|max:100',
                    'birthDate' => ['bail','required','date_format:m/d/Y','after:1/1/1918', new checkAge],
                    'birthPlace' => ['bail',new checkName,'required','max:30'],
                    'gender' => [
                        'bail',
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'citizenship' => 'bail|alpha|required|max:25',
                    'civilStatus' => [
                        'bail',
                        'required',
                        Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                    ],
                    'nameOfSpouse' => ['bail','required_if:civilStatus,Married','required_with:spouseBirthDate','max:40', 'nullable',new checkName],
                    'spouseBirthDate' => 'bail|required_with:nameOfSpouse|nullable|date|before:today',
                    'fathersName' => ['bail','required_with:fatherOccupation','max:40', 'nullable',new checkName],
                    'fatherOccupation' => ['bail','required_with:fathersName','max:25', 'nullable', new checkOccupation],
                    'mothersName' => ['bail','required_with:motherOccupation','max:40', 'nullable',new checkName],
                    'motherOccupation' => ['bail','required_with:mothersName','max:25', 'nullable', new checkOccupation],
                    'contactPerson' => ['bail','required','max:40', 'nullable', new checkName],
                    'contactPersonAddress' => 'bail|required|max:100',
                    'contactPersonContactNumber' => ['bail','required', new checkContactNum],
                    'sss' => 'bail|unique:member,SSS|required|max:10',
                    'licenseNo' => ['bail','required_with:licenseExpiryDate','max:20'],
                    'licenseExpiryDate' => 'bail|required_with:licenseNo|nullable|date|after:today',
                    'children.*' => ['bail','required_with:childrenBDay.*','distinct', 'nullable', new checkName, 'max:40'],
                    'childrenBDay.*' => 'bail|required_with:children.*|nullable|date|before:tomorrow'
                ];
            }
            case 'PATCH':
            {
//                dd($this->all());
                    return [
                        'lastName' => ['bail','required',new checkName,'max:25'],
                        'firstName' => ['bail','required',new checkName,'max:25'],
                        'middleName' => ['bail','required',new checkName,'max:25'],
                        'contactNumber' => ['bail',new checkContactNum],
                        'address' => 'bail|required|max:100',
                        'provincialAddress' => 'bail|required|max:100',
                        'birthDate' => ['bail','required','date_format:m/d/Y','after:1/1/1918', new checkAge],
                        'birthPlace' => ['bail',new checkName,'required','max:30'],
                        'gender' => [
                            'bail',
                            'required',
                            Rule::in(['Male', 'Female'])
                        ],
                        'citizenship' => 'bail|alpha|required|max:25',
                        'civilStatus' => [
                            'bail',
                            'required',
                            Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                        ],
                        'nameOfSpouse' => ['bail','required_if:civilStatus,Married','required_with:spouseBirthDate','max:40', 'nullable', new checkName],
                        'spouseBirthDate' => 'bail|required_with:nameOfSpouse|nullable|date|before:today',
                        'fathersName' => ['bail','required_with:fatherOccupation','max:40', 'nullable', new checkName],
                        'fatherOccupation' => ['bail','required_with:fathersName','max:25', 'nullable', new checkOccupation],
                        'mothersName' => ['bail','required_with:motherOccupation','max:40', 'nullable',new checkName],
                        'motherOccupation' => ['bail','required_with:mothersName','max:25', 'nullable', new checkOccupation],
                        'contactPerson' => ['bail','required','max:40', 'nullable', new checkName],
                        'contactPersonAddress' => 'bail|required|max:100',
                        'contactPersonContactNumber' => ['bail','required',new checkContactNum],
                        'sss' => 'bail|unique:member,SSS,'.$this->route('operator')->member_id.',member_id|required|max:10',
                        'licenseNo' => ['bail','required_with:licenseExpiryDate','max:20'],
                        'licenseExpiryDate' => 'bail|required_with:licenseNo|nullable|date|after:today',
                        'children.*' => ['bail','required_with:childrenBDay.*','distinct', 'nullable', new checkName,'max:40'],
                        'childrenBDay.*' => 'bail|required_with:children.*|nullable|date|before:tomorrow'
                    ];

            }
            default:break;
        }
    }
}
