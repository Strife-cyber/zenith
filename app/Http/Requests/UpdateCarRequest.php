<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'make' => 'string|max:80',
            'model' => 'string|max:80',
            'year' => 'string|max:80',
            'transmission' => 'string|max:80|in:manual,automatic',
            'fuel' => 'string|in:petrol,diesel,electric',
            'condition' => 'string|in:new,used',
        ];
    }
}
