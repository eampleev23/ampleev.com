<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailingRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email:rfc',
                'max:100',
                Rule::unique('mailings', 'email')->where(function ($query) {
                    return $query->where('confirmed', 1);
                }),
            ],
            'company_name' => ['nullable', 'size:0'],
        ];
    }

    protected function prepareForValidation()
    {
        $email = $this->input('email');

        $this->merge([
            'email' => is_string($email) ? mb_strtolower(trim($email)) : $email,
            'company_name' => $this->input('company_name'),
        ]);
    }

    public function messages()
    {
        return [
            'email.required' => 'Укажите email.',
            'email.email' => 'Пожалуйста, используйте валидный email.',
            'email.max' => 'Email слишком длинный.',
            'email.unique' => 'Этот email уже подписан.',
        ];
    }
}
