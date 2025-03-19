<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'category' => 'required|string|in:car',
            'type' => 'required|string|in:rent,sale',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,sold,rented,pending',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB max per file
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|digits:4',
            'fuel' => 'required|string|in:petrol,diesel,electric',
            'transmission' => 'required|string|in:manual,automatic',
            'condition' => 'required|string|in:new,used',
        ];
    }
}
