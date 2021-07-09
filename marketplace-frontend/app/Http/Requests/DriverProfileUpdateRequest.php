<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DriverProfileUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            //'phone' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/','unique:users,phone,'.Auth::user()->id],
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:users,phone,' . Auth::user()->id],
            'age' => ['required', 'numeric','between:21,100'],
            'gender' => ['required', 'string', 'in:male,female'],
            'vehicle' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'phone.digits_between' => 'The :attribute must be between :min to :max digits.',
            'age.between' => 'The :attribute must be between :min to :max.',
        ];
      
    }

}
