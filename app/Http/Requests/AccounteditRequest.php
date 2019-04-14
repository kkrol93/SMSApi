<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AccounteditRequest extends FormRequest
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
        $account = $this->route('account');

        return [
            'service' => 'required|max:255|unique:accounts,service,'.$account->id,
            'signature' => 'required|max:255',


        ];
    }
    public function messages()
{
    return [
        'service.required' => 'Serwis jest wymagany!',
        'signature.required'  => 'Podpis jest wymagany!',
        'service.unique' => 'Już istnieje taki serwis'

    ];
}
}
