<?php

namespace Modules\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required|string|email|max:255|bail',
            'password' => 'required|string|min:6|max:32',
        ];

        if (get_config('captcha')) {
            $rules['g-recaptcha-response'] = 'required|bail|recaptcha';
        }


        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
