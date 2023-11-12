<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            return [
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'original_price'=>'required',
                'description' => 'required',
                'quantity' => 'required',
                'size' => 'required',
                'image_url' => 'required',
                'product_category_id' => 'required',
                'status' => 'required'
            ];

    }
        public function messages(): array{
        return [
            'image_url.required' => 'You forget Image',
            'name.required' => 'You forget Name',
            'price.required' => 'You forget Price',
            'quantity.required' => 'You forget Quantity',
            'size.required' => 'You forget Size',
        ];
    }

}
