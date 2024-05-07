<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'fromDate' => ['required', 'date'],
            'toDate' => ['nullable', 'date', 'after_or_equal:fromDate'],
            'location' => ['nullable', 'string', 'max:255'],
            'e_title' => ['required', 'string', 'max:255'],
            'e_description' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'fromDate.required' => 'Datum začetka je obvezen.',
            'fromDate.date' => 'Datum začetka mora biti v obliki datuma.',
            'toDate.date' => 'Datum konca mora biti v obliki datuma.',
            'toDate.after_or_equal' => 'Datum konca mora biti enak ali poznejši od datuma začetka.',
            'location.string' => 'Lokacija mora biti besedilo.',
            'location.max' => 'Lokacija ne sme biti daljša od :max znakov.',
            'e_title.required' => 'Naslov je obvezen.',
            'e_title.string' => 'Naslov mora biti besedilo.',
            'e_title.max' => 'Naslov ne sme biti daljši od :max znakov.',
            'e_description.required' => 'Opis je obvezen.',
            'e_description.string' => 'Opis mora biti besedilo.',
        ];
    }
}
