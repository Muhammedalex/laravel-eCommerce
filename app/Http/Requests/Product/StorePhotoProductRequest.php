<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoProductRequest extends FormRequest
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
            'photo' => 'required|array',
            'photo.*' => [
                'required',
                'image'
            ],
            'colors' => 'required',
            'colors.*' => 'required',
            'sizes' => 'required',
            'sizes.*' => 'required',
            'tags' => 'required',
            'tags.*' => 'required',
        ];
        //|exists:sizes,size
    }
}
