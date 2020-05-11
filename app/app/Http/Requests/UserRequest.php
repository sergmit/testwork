<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
                'email' => 'required|email|unique:App\User,email',
                'password' => 'required|min:5|max:10'
            ];
        }

        if ($this->method() === self::METHOD_PUT) {
            return [
                'id' => 'required|numeric',
                'name' => 'max:100|min:4',
                'email' => 'email',
                'password' => 'min:5|max:10'
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
