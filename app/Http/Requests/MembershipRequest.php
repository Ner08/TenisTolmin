<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'price_adults' => 'required|string|max:255',
            'price_seniors' => 'required|string|max:255',
            'price_students' => 'required|string|max:255',
            'price_kids' => 'required|string|max:255',
            'price_family' => 'required|string|max:255',
            'trr' => 'required|string|max:255',
            'sklic' => 'required|string|max:255',
            'namen' => 'required|string|max:255',
            'prejemnik' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'year.required' => 'Leto cenika je obvezno.',
            'year.integer' => 'Leto cenika mora biti celo število.',
            'year.min' => 'Leto cenika mora biti večje ali enako 1900.',
            'year.max' => 'Leto cenika ne sme biti večje kot ' . (date('Y') + 10) . '.',
            'price_adults.required' => 'Cena za odrasle je obvezna.',
            'price_seniors.required' => 'Cena za seniorje je obvezna.',
            'price_students.required' => 'Cena za študente in dijake je obvezna.',
            'price_kids.required' => 'Cena za otroke je obvezna.',
            'price_family.required' => 'Cena za družine je obvezna.',
            'trr.required' => 'Številka transakcijskega računa je obvezna.',
            'sklic.required' => 'Sklic je obvezen.',
            'namen.required' => 'Namen plačila je obvezen.',
            'prejemnik.required' => 'Prejemnik plačila je obvezen.',
            'string' => ':attribute mora biti besedilo.',
            'max' => ':attribute ne sme biti daljši od :max znakov.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'year' => 'leto cenika',
            'price_adults' => 'cena odrasli',
            'price_seniors' => 'cena seniorji',
            'price_students' => 'cena študenti in dijaki',
            'price_kids' => 'cena otroci',
            'price_family' => 'cena družina',
            'trr' => 'številka transakcijskega računa',
            'sklic' => 'sklic',
            'namen' => 'namen plačila',
            'prejemnik' => 'prejemnik plačila',
        ];
    }
}
