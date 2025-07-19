<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryUpdateRequest extends FormRequest
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
      $country = $this->route('country');
      $countryId = is_object($country) ? $country->id : $country;
      
      return [
        'name' => [
          'required',
          'string',
          'max:255',
          Rule::unique('countries', 'name')->ignore($countryId),
        ],
        'code' => [
          'required',
          'string',
          'size:3',
          Rule::unique('countries', 'code')->ignore($countryId),
        ],
      ];
    }
}
