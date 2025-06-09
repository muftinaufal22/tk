<?php

namespace Modules\PPDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataMuridRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'email'         => 'required|email',
            'tempat_lahir'  => 'required',
            'tgl_lahir'     => 'required',
            'agama'         => 'required',
            'whatsapp'      => 'required|numeric',
            'alamat'        => 'required',
            'jenis_kelamin'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'Nama Lengkap tidak boleh kosong.',
            'email.required'         => 'Email tidak boleh kosong.',
            'email.email'       => 'Email yang digunakan tidak valid.',
            'tempat_lahir.required'  => 'Tempat Lahir tidak boleh kosong.',
            'tgl_lahir.required'     => 'Tanggal Lahir tidak boleh kosong.',
            'agama.required'         => 'Agama tidak boleh kosong.',
            'whatsapp.required'      => 'No WhatsApp tidak boleh kosong.',
            'whatsapp.numeric'       => 'No WhatsApp hanya mendukung angka.',
            'alamat.required'        => 'Alamat tidak boleh kosong.',
            'jenis_kelamin.required'  => 'jenis kelamin tidak boleh kosong.'
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
