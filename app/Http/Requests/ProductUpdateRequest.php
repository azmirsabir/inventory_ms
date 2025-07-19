<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
      $product = $this->route('product');
      $productId = is_object($product) ? $product->id : $product;
      return [
        'name'        => 'sometimes|required|string|max:255',
        'sku'         => [
          'sometimes', 'required', 'string', 'max:100',
          Rule::unique('products', 'sku')->ignore($productId),
        ],
        'status'      => 'sometimes|required|in:active,inactive',
        'description' => 'nullable|string',
        'price'       => 'sometimes|required|numeric|min:0',
      ];
    }
}
