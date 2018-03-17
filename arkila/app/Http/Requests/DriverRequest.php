<?php

namespace App\Http\Requests;

use App\Rules\checkAge;
use App\Rules\checkContactNum;
use App\Rules\checkLicenseNumber;
use App\Rules\checkName;
use App\Rules\checkOccupation;
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
                    'lastName' => ['required',new checkName,'max:35'],
                    'firstName' => ['required',new checkName,'max:35'],
                    'operator' => 'nullable|exists:member,member_id|numeric',
                    'middleName' => ['required',new checkName,'max:35'],
                    'contactNumber' => [new checkContactNum],
                    'address' => 'required|max:100',
                    'provincialAddress' => 'required|max:100',
                    'birthDate' => ['required','date_format:m/d/Y','after:1/1/1918', new checkAge],
                    'birthPlace' => [new checkName,'required','max:50'],
                    'gender' => [
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'citizenship' => 'alpha|required|max:35',
                    'civilStatus' => [
                        'required',
                        Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                    ],
                    'nameOfSpouse' => ['required_if:civilStatus,Married','required_with:spouseBirthDate','max:120', 'nullable',new checkName],
                    'spouseBirthDate' => 'required_with:nameOfSpouse|nullable|date|before:today',
                    'fathersName' => ['required_with:fatherOccupation','max:120', 'nullable',new checkName],
                    'fatherOccupation' => ['required_with:fathersName','max:50','nullable', new checkOccupation],
                    'mothersName' => ['required_with:motherOccupation','max:120', 'nullable',new checkName],
                    'motherOccupation' => ['required_with:mothersName','max:50','nullable', new checkOccupation],
                    'contactPerson' => ['required','max:120', new checkName],
                    'contactPersonAddress' => 'required|max:50',
                    'contactPersonContactNumber' => ['required',new checkContactNum],
                    'sss' => 'unique:member,SSS|required|max:10',
                    'licenseNo' => ['required','max:20'],
                    'licenseExpiryDate' => 'required|date|after:today',
                    'children.*' => ['required_with:childrenBDay.*','distinct', 'nullable',new checkName, 'max:120'],
                    'childrenBDay.*' => 'required_with:children.*|nullable|date|before:tomorrow'
                ];
            }
            case 'PATCH':
            {

                return [
                    'lastName' => ['required',new checkName,'max:35'],
                    'firstName' => ['required',new checkName,'max:35'],
                    'operator' => 'nullable|exists:member,member_id|numeric',
                    'middleName' => ['required',new checkName,'max:35'],
                    'contactNumber' => [new checkContactNum],
                    'address' => 'required|max:100',
                    'provincialAddress' => 'required|max:100',
                    'birthDate' => ['required','date_format:m/d/Y','after:1/1/1918', new checkAge],
                    'birthPlace' => [new checkName,'required','max:50'],
                    'gender' => [
                        'required',
                        Rule::in(['Male', 'Female'])
                    ],
                    'citizenship' => 'alpha|required|max:35',
                    'civilStatus' => [
                        'required',
                        Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
                    ],
                    'nameOfSpouse' => ['required_if:civilStatus,Married','required_with:spouseBirthDate','max:120', 'nullable',new checkName],
                    'spouseBirthDate' => 'required_with:nameOfSpouse|nullable|date|before:today',
                    'fathersName' => ['required_with:fatherOccupation','max:120', 'nullable',new checkName],
                    'fatherOccupation' => ['required_with:fathersName','max:50', 'nullable',new checkOccupation],
                    'mothersName' => ['required_with:motherOccupation','max:120', 'nullable',new checkName],
                    'motherOccupation' => ['required_with:mothersName','max:50', 'nullable',new checkOccupation],
                    'contactPerson' => ['required','max:120', 'nullable',new checkName],
                    'contactPersonAddress' => 'required|max:50',
                    'contactPersonContactNumber' => ['required',new checkContactNum],
                    'sss' => 'unique:member,SSS,'.$this->route('driver')->member_id.',member_id|required|max:10',
                    'licenseNo' => ['required','max:20'],
                    'licenseExpiryDate' => 'required|date|after:today',
                    'children.*' => ['required_with:childrenBDay.*','distinct', 'nullable',new checkName, 'max:120'],
                    'childrenBDay.*' => 'required_with:children.*|nullable|date|before:tomorrow'
                ];
            }
            default:break;
        }
    }    
}

