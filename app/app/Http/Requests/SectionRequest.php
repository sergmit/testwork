<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->method() === self::METHOD_POST) {
            return [
                'name' => 'required|max:100|min:4',
                'description' => 'required|min:50|max:500',
                'logo' => 'required|image',
                'users' => 'array'
            ];
        }

        if ($this->method() === self::METHOD_PUT) {
            return [
                'id' => 'required|numeric',
                'name' => 'max:100|min:4',
                'description' => 'min:50|max:500',
                'logo' => 'image',
                'users' => 'array'
            ];
        }

        return [];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
