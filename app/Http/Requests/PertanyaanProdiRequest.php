<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PertanyaanProdiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_prodi' => ['required', 'array', 'min:1'],
            'id_prodi.*' => ['integer', 'exists:prodis,id'],
        ];
    }
}
