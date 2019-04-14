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
        $user = $this->route('user');

        return [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'password' => ['required',
               'min:6',
               'confirmed']


        ];
    }
    public function messages()
    {
        return [
        'email.required' => 'E-mail jest wymagany!',
        'name.required'  => 'Imie jest wymagane!',
        'emai.unique' => 'Już istnieje użytkownik z podanym adresem email!'

    ];
    }
}
