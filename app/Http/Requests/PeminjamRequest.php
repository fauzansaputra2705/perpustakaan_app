<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamRequest extends FormRequest
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
        return [
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required',
            // 'tanggal_kembali' => 'required',
            'lama_pinjam' => 'required',
            'keterangan' => 'required',
            'kondisi_buku_minjam' => 'required|in:baik,hilang,rusak',
        ];
    }
}