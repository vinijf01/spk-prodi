<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PilihanProdiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'jurusansekolah_id' => ['required', 'integer', 'exists:jurusan_sekolahs,id'],
        ];
    }
}
