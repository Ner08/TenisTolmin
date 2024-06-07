<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Nastavite na false, če želite omejiti dostop
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:3000',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Elektronski naslov je obvezen.',
            'email.email' => 'Elektronski naslov mora biti veljaven.',
            'email.max' => 'Elektronski naslov ne sme presegati 255 znakov.',
            'content.required' => 'Sporočilo je obvezno.',
            'content.string' => 'Sporočilo mora biti besedilo.',
            'content.max' => 'Sporočilo ne sme presegati 3000 znakov.',
        ];
    }
}
