<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Müşteri ID\'si gereklidir',
            'customer_id.exists' => 'Seçilen müşteri bulunamadı',
            'items.required' => 'En az bir ürün gereklidir',
            'items.*.product_id.required' => 'Her ürün için ürün ID\'si gereklidir',
            'items.*.product_id.exists' => 'Seçilen ürünlerden bir veya birkaçı bulunamadı',
            'items.*.quantity.required' => 'Her ürün için miktar belirtilmelidir',
            'items.*.quantity.min' => 'Her ürün için miktar en az 1 olmalıdır',
        ];
    }
}
