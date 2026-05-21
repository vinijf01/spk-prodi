<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HasilPilihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Validasi detail `p<ID>` bersifat dinamis karena bergantung data Kriteria.
        // Untuk stabilitas flow, validasi minimum ini memastikan struktur payload benar.
        return [
            'data' => ['required', 'array', 'min:1'],
            'data.*' => ['required', 'array'],
            'data.*.nama' => ['required', 'string', 'max:255'],
        ];
    }
}
