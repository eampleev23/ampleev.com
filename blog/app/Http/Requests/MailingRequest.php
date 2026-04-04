<?php

namespace App\Http\Requests;

use App\Support\SiteLocale;
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
        $isEn = SiteLocale::resolve($this) === SiteLocale::EN;

        return [
            'email.required' => $isEn ? 'Please provide an email.' : 'Укажите email.',
            'email.email' => $isEn ? 'Please use a valid email.' : 'Пожалуйста, используйте валидный email.',
            'email.max' => $isEn ? 'Email is too long.' : 'Email слишком длинный.',
            'email.unique' => $isEn ? 'This email is already subscribed.' : 'Этот email уже подписан.',
        ];
    }
}
