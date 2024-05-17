<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserFormValidation extends AbstractFormRequest
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
        $id = $this->route('user')->id ?? null;
        $data = [
            'name' => ['required','string', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:male,female'],
            'country_id' => ['required', 'numeric'],
            'password' => ['required','string','min:8'],
        ];

        if(request()->isMethod('post')){
            $data['email'] =  ['required','email', 'max:50','unique:users,email'];
        }elseif(request()->isMethod('put')){
            $data['email'] =  ['required','email', 'max:50','unique:users,email,'.$id];
        }

        return $data;
    }
}
