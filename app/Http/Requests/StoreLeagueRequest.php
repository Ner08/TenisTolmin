<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeagueRequest extends FormRequest
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
            'name' => ['required', 'unique:leagues,name', 'max:40'], // Use 'name' as the column name
            'description' => ['required', 'max:500'],
            'start_date' => ['required'],
            'end_date' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime lige je obvezno.',
            'name.unique' => 'Ime lige že obstaja.',
            'name.max' => 'Ime lige ne sme biti daljše od 40 znakov.',
            'description.required' => 'Opis lige je obvezen.',
            'description.max' => 'Opis lige ne sme biti daljši od 500 znakov.',
            'start_date.required' => 'Datum začetka je obvezen.'
        ];
    }
}
