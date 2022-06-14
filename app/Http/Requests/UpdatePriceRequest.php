<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => ['nullable', 'exists:App\Models\Product,id'],
            'variant' => ['nullable', 'string', 'max:100'],
            'value' => ['nullable', 'gt:0'],
            'active' => ['nullable', 'bool'],
        ];
    }
}
