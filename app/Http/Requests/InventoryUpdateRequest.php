<?php
  
  namespace App\Http\Requests;
  
  use Illuminate\Foundation\Http\FormRequest;
  use Illuminate\Validation\Rule;
  
  class InventoryUpdateRequest extends FormRequest
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
      $inventoryId = $this->route('inventory');
      
      return [
        'product_id' => [
          'required',
          'exists:products,id',
          Rule::unique('inventories')
            ->ignore($inventoryId)
            ->where(fn($query) => $query
              ->where('warehouse_id', $this->input('warehouse_id'))
            ),
        ],
        'warehouse_id' => 'required|exists:warehouses,id',
        'minimum_quantity' => 'required|integer|min:0',
      ];
    }
  }
