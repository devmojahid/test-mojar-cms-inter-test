<?php

namespace Modules\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\Models\User;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {


        return [
            'email' => [
                'required',
                'email',
                // Rule::modelExists(User::class, 'email', function ($query) {
                //     $query->where('status', User::STATUS_ACTIVE);
                // })
                Rule::exists('users', 'email')->where(function ($query) {
                    $query->where('status', User::STATUS_ACTIVE);
                })
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
