<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class CustomersRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'max:255',
            'amount' => 'regex:/^(\d+(?:[\.\,]\d{2})?)$/|nullable',
            'count' => 'numeric|nullable'
        ];
    }
    public function messages()
    {
        return [
        'name.required' => 'Nazwa jest wymagana!',
        'amount.numeric'  => 'W polu stawka - tylko cyfry są dozwolone!',
        'count.numeric'  => 'W polu limit - tylko cyfry są dozwolone!',
    ];
    }
}
