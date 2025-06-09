<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hari'         => ['required'],
            'jam_mulai'    => ['required'],
            'jam_selesai'  => ['required'],
            'pelajaran'    => ['required'],
            'kelas'        => ['required'],
            'is_active'    => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
           'hari.required'         => 'Hari tidak boleh kosong.',
           'jam_mulai.required'    => 'Jam mulai tidak boleh kosong.',
           'jam_selesai.required'  => 'Jam selesai tidak boleh kosong.',
           'pelajaran.required'    => 'Pelajaran tidak boleh kosong.',
           'kelas.required'        => 'Kelas tidak boleh kosong.',
        ];
    }
}
