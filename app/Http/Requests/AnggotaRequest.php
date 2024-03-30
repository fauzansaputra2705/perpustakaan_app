<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnggotaRequest extends FormRequest
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
            'kelas_id' => 'required|exists:kelas,id',
            'kode_anggota' => 'required|unique:anggotas,id,' . $this->id,
            'nama' => 'required',
            'email' => 'required|unique:anggotas,email,' . $this->id,
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'telpon' => 'required',
            'alamat' => 'required',
        ];

        if ($this->foto) {
            $rules['foto'] = 'required|mimes:png,jpg|max:500';
        }
        return $rules;
    }
}
