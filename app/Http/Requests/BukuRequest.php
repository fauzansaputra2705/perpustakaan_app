<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
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
            'kategori_id' => 'required|exists:kategoris,id',
            'rak_buku_id' => 'required|exists:rak_bukus,id',
            'title' => 'required',
            'slug' =>
            'required|unique:bukus,slug,' . $this->id,
            'publish_date' => 'required|date',
            'sinopsis' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'language' => 'required',
            'isbn' => 'required|unique:bukus,isbn,' . $this->id,
            'jumlah_stok' => 'required',
            'tahun_terbit' => 'required',
            'cover' => 'required|mimes:png,jpg|max:500',
            'status_publish' => 'required|in:0,1'
        ];
    }
}
