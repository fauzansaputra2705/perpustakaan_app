<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'jenis_akun'        => 'required|string|exists:roles,name',
            'username'          => 'required',
            'name'              => 'required',
            'email'             => ['required', Rule::unique('users', 'email')->ignore($this->id)],
            'password'          => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ];

        if ($this->jenis_akun == 'provinsi' || $this->jenis_akun == 'kabupaten') {
            $rules['provinsi_id'] = 'required|exists:m_provinsi,id';
            unset($rules['nik']);
            unset($rules['telepon']);
            if ($this->jenis_akun == 'kabupaten') {
                $rules['kabupaten_id'] = 'required|exists:m_kabupaten,id';
            }
        } else {
            $rules['jenis_peran_id'] = 'required|exists:m_jenis_peran,id';
        }

        return $rules;
    }
}
