<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'receiver_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'paid' => 'boolean',
            'received' => 'boolean',
        ];
    }

    /**
     *  Custom attribute names
     */
    public function attributes()
    {
        return [
            'receiver_id' => 'Driver',
        ];
    }
}
