<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ServerseditRequest extends FormRequest
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
        $server = $this->route('server');

        return [
            'ip' => 'required|max:255|unique:servers,ip,'.$server->id,
            'name' => 'required|max:255',


        ];
    }
    public function messages()
{
    return [
        'ip.required' => 'IP jest wymagane!',
        'name.required'  => 'Nazwa jest wymagana!',
        'ip.unique' => 'Już istnieje takie IP!'

    ];
}
}
