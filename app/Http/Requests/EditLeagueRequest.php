<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditLeagueRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:40'], // Use 'name' as the column name
            'description' => ['required', 'max:500'],
            'short_description' => ['nullable', 'max:200'],
            'start_date' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime lige je obvezno.',
            'name.max' => 'Ime lige ne sme biti daljše od 40 znakov.',
            'description.required' => 'Opis lige je obvezen.',
            'description.max' => 'Opis lige ne sme biti daljši od 500 znakov.',
            'short_description.max' => 'Kratek opis ne sme biti daljši od 200 znakov.',
            'start_date.required' => 'Datum začetka je obvezen.'
        ];
    }
}