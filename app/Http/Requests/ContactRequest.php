<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $contactId = $this->route('contact');
        
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:contacts,email,' . $contactId,
            'phone' => 'required|string|min:10',
        ];
    }
}
