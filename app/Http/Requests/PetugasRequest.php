<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetugasRequest extends FormRequest
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
     *
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        $rules = [
            // 'user_id' => 'required|exists:users,id',
            'kode_petugas' => 'required|unique:petugas,id,' . $this->id,
            'email' => 'required|unique:petugas,email,' . $this->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'telpon' => 'required',
            'alamat' => 'required',

        ];

        if (!$this->id) {
            $rules['foto'] = 'required|mimes:png,jpg|max:500';
        }
        return $rules;
    }
}
