<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'p_name' => ['required', 'max:40'], // Use 'name' as the column name
            'points' => ['nullable','integer'], // Set default value to 0
            'is_fake' => ['nullable'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'p_name.required' => 'Ime igralca je obvezno.',
            'p_name.max' => 'Ime igralca ne sme biti daljše od 40 znakov.',
            'is_fake.nullable' => 'bla',
        ];
    }
}
