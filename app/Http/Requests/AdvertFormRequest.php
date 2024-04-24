<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdvertFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:200',
            'text' => 'required|max:1000',
            'photos' => 'nullable|regex:/^(http[s]?:\/\/[\w.\/\-]+[\s\,]?){0,3}$/',
            'price' => 'nullable|int'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите заголовок объявления',
            'title.max' => 'Длина заголовка не должна превышать 200 символов',
            'text.required' => 'Введите текст объявления',
            'text.max' => 'Длина текста не должна превышать 1000 символов',
            'photos.regex' => 'Приложите ссылки на фотографии, разделённые запятой или пробелом. Нельзя приложить больше трёх фотографий',
            'price' => 'Введите сумму цифрами без лишних символов'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
