<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLandRequest extends FormRequest
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
            'title' => 'required|string|max:80',
            'description' => 'required|string',
            'category' => 'required|string|in:apartment,car,land',
            'type' => 'required|string|in:rent,sale',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,sold,rented,pending',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'size' => 'required|numeric|min:0',
            'zoning' => 'required|string|in:residential,commercial,agricultural',
            'document' => 'required|boolean',
        ];
    }
}
