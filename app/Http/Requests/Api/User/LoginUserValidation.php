<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserValidation extends AbstractFormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required','email', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
