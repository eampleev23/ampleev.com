<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $isAuthorized = Auth::check();
        Log::info('CommentRequest::authorize()', [
            'is_authorized' => $isAuthorized,
            'user_id' => Auth::id(),
        ]);
        return $isAuthorized;
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        Log::info('CommentRequest::prepareForValidation()', [
            'user_id' => Auth::id(),
            'article_id' => $this->article_id,
            'content_length' => strlen($this->content ?? ''),
        ]);
    }
    
    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        Log::warning('CommentRequest::failedAuthorization()', [
            'user_id' => Auth::id(),
        ]);
        parent::failedAuthorization();
    }
    
    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::error('CommentRequest::failedValidation()', [
            'user_id' => Auth::id(),
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
        ]);
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'content' => 'required|string|min:3|max:5000',
            'article_id' => 'required|integer|exists:articles,id',
            'article_text_url' => 'required|string',
            'comment_id' => 'nullable|integer',
        ];
        
        // Если comment_id передан и не равен 0, проверяем что комментарий существует
        if ($this->comment_id && $this->comment_id != '0') {
            $rules['comment_id'] = 'required|integer|exists:comments,id';
        }
        
        return $rules;
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
