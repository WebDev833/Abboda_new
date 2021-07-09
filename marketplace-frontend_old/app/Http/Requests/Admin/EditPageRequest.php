<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EditPageRequest extends FormRequest
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
            'title:en' => ['required', 'string'],
            'slug:en' => ['required', 'string'],
            'title:ar' => ['required', 'string'],
            'slug:ar' => ['required', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug:en' => Str::slug($this->input('slug:en')),
            'slug:ar' => Str::slug($this->input('slug:ar')),
        ]);
    }
}
