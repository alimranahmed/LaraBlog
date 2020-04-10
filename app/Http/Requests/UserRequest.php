<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required';
        }
        return $rules;
    }
}
