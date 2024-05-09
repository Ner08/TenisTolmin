<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchupRequest extends FormRequest
{
    /**
     * Določi, ali je uporabnik pooblaščen za izvedbo tega zahtevka.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Prilagodite glede na svojo logiko pooblastil
    }

    /**
     * Pridobi pravila preverjanja, ki se uporabljajo za zahtevek.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team1_id' => 'integer|required',
            't1_tag' => 'nullable',
            'team2_id' => 'integer|required',
            't2_tag' => 'nullable',
            't1_first_set' => 'nullable|integer',
            't2_first_set' => 'nullable|integer',
            't1_second_set' => 'nullable|integer',
            't2_second_set' => 'nullable|integer',
            't1_third_set' => 'nullable|integer',
            't2_third_set' => 'nullable|integer',
            'round' => 'required|integer',
            'exception' => 'nullable|string|max:30',
            'bracket_id' => ['required', 'integer'],
        ];
    }

    /**
     * Pridobi prilagojena sporočila o napakah za preverjevalne napake.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'team1_id.integer' => 'ID ekipe 1 mora biti celo število.',
            'team1_id.required' => 'ID ekipe 1 je obvezen.',
            'team2_id.integer' => 'ID ekipe 2 mora biti celo število.',
            'team2_id.required' => 'ID ekipe 2 je obvezen.',
            'round.required' => 'Krog je obvezen.',
            'round.integer' => 'Krog mora biti celo število.',
            'exception.max' => 'Izjema ne sme biti daljša od :max znakov.',
        ];
    }
}
