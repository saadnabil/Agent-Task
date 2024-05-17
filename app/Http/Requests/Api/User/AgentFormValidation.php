<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AgentFormValidation extends AbstractFormRequest
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
        $id = $this->route('agent')->id ?? null;
        $data = [
            'firstname' => ['required','string', 'max:50'],
            'lastname' => ['required','string', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'max:20'],
            'birthdate' => ['required','date','date_format:Y-m-d'],
            'balance' => ['required','numeric','min:0'],
            'country_id' => ['required', 'numeric'],
        ];

        if(request()->isMethod('post')){
            $data['email'] =  ['required','email', 'max:50','unique:agents,email'];
        }elseif(request()->isMethod('put')){
            $data['email'] =  ['required','email', 'max:50','unique:agents,email,'.$id];
        }

        return $data;
    }
}
