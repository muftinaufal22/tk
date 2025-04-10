<?php

namespace Modules\PPDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BerkasMuridRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kartu_keluarga'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'akte_kelahiran'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp'             => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto'            => 'mimes:jpg,jpeg,png,pdf|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'kartu_keluarga.required' => 'File Kartu Keluarga tidak boleh kosong.',
            'kartu_keluarga.mimes'    => 'Kartu Keluarga hanya mendukung .jpg .jpeg .png atau pdf.',
            'kartu_keluarga.max'      => 'Ukuran file tidak boleh lebih dari 2MB.',

            'akte_kelahiran.required' => 'File Akte Kelahiran tidak boleh kosong.',
            'akte_kelahiran.mimes'    => 'Akte Kelahiran hanya mendukung .jpg .jpeg .png atau pdf.',
            'akte_kelahiran.max'      => 'Ukuran file tidak boleh lebih dari 2MB.',

            'ktp.required'            => 'KTP tidak boleh kosong.',
            'ktp.mimes'               => 'KTP hanya mendukung .jpg .jpeg .png atau pdf.',
            'ktp.max'                 => 'Ukuran file tidak boleh lebih dari 2MB.',

            'foto.mimes'              => 'Foto hanya mendukung .jpg .jpeg .png atau pdf.',
            'foto.max'                => 'Ukuran file tidak boleh lebih dari 2MB.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
