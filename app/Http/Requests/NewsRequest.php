<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Naslov je obvezen.',
            'title.string' => 'Naslov mora biti besedilo.',
            'title.max' => 'Naslov ne sme biti daljši od :max znakov.',
            'content.required' => 'Vsebina je obvezna.',
            'content.string' => 'Vsebina mora biti besedilo.',
            'image.string' => 'Napaka pri formatu.'
        ];
    }
}
