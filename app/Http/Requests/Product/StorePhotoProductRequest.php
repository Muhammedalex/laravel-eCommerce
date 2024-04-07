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
            'color' => 'required',
            'color.*' => 'required|exists:colors,color',
            'size' => 'required',
            'size.*' => 'required|exists:sizes,size',
            'tag' => 'required',
            'tag.*' => 'required|exists:tags,tag',
        ];
    }
}
