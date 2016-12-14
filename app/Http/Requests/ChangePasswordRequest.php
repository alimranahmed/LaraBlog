<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
        ];
    }

    /*public function failedValidation(Validator $validator) {
        $messages = $validator->getMessageBag()->toArray();
        $messageStr = '';
        foreach ($messages as $message){
            $messageStr .= implode(', ', $message);
        }
        return redirect()->back()->with('errorMsg', $messageStr);
    }*/
}
