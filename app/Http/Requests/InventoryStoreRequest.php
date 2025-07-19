<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryStoreRequest extends FormRequest
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
          'product_id' => [
            'required',
            'exists:products,id',
            Rule::unique('inventories')->where(fn ($query) => $query
              ->where('warehouse_id', $this->input('warehouse_id'))
            ),
          ],
          'warehouse_id' => 'sometimes|exists:warehouses,id',
          'minimum_quantity' => 'sometimes|integer|min:0',
        ];
    }
    public function messages(): array
    {
      return [
        'product_id.unique' => 'This product already exists in the selected warehouse.',
      ];
    }
}
