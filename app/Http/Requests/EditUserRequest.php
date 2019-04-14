<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nazwa jest wymagana!',
            'email.required' => 'Adres E-mail jest wymagany!',
            'email.email' => 'Podany e-mail jest nieprawidłowy!',
            'email.unique' => 'Podany e-mail jest zajęty!',
        ];
    }
}
