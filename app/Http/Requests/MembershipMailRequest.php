<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipMailRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'max:20',
            'type' => 'required|string|in:Odrasel,Starejši od 65 let,Dijak ali študent,Otrok,Družina',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime in priimek je obvezen.',
            'name.string' => 'Ime in priimek mora biti besedilo.',
            'name.max' => 'Ime in priimek ne sme presegati 255 znakov.',
            'email.required' => 'Elektronski naslov je obvezen.',
            'email.email' => 'Elektronski naslov mora biti veljaven.',
            'email.max' => 'Elektronski naslov ne sme presegati 255 znakov.',
            'telephone.max' => 'Telefonska številka ne sme presegati 20 znakov.',
            'type.required' => 'Tip članarine je obvezen.',
            'type.in' => 'Izbrani tip članarine ni veljaven.',
        ];
    }
}
