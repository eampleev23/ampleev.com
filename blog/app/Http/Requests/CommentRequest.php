<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|min:3|max:5000',
            'article_id' => 'required|integer|exists:articles,id',
            'article_text_url' => 'required|string',
            'comment_id' => 'nullable|integer|exists:comments,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'content.required' => 'Комментарий не может быть пустым.',
            'content.min' => 'Комментарий должен содержать минимум 3 символа.',
            'content.max' => 'Комментарий не может быть длиннее 5000 символов.',
            'article_id.exists' => 'Статья не найдена.',
            'comment_id.exists' => 'Родительский комментарий не найден.',
        ];
    }
}
