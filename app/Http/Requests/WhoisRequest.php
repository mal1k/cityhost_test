<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhoisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'domain' => [
                'required',
                'string',
                'max:253',
                'regex:/^(?=.{1,253}$)(?:(?!-)[\pL\pN-]{1,63}(?<!-)\.)+[\pL]{2,63}$/u',
            ],
            'format' => [
                'string',
                'in:json,raw',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'domain.required' => 'Domain is required',
            'domain.regex'    => 'Domain is incorrect',
        ];
    }
    
    protected function prepareForValidation(): void
    {
        $this->merge([
            'format' => $this->input('format', 'json'),
        ]);
    }
}