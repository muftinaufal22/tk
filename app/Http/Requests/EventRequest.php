<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        $eventId = $this->route('backend_event') ? $this->route('backend_event') : null;
        
        return [
            'title' => 'required|max:255|unique:events,title,' . $eventId,
            // 'desc' => 'required',
            'jenis_event' => 'required|in:1,2,3',
            'acara' => 'required|date',
            'lokasi' => 'required|max:255',
            'is_Active' => 'sometimes|in:0,1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Judul event harus diisi.',
            'title.unique' => 'Judul event sudah ada.',
            // 'desc.required' => 'Deskripsi event harus diisi.',
            'jenis_event.required' => 'Jenis event harus dipilih.',
            'jenis_event.in' => 'Jenis event tidak valid.',
            'acara.required' => 'Waktu acara harus diisi.',
            'acara.date' => 'Format waktu acara tidak valid.',
            'lokasi.required' => 'Lokasi acara harus diisi.',
        ];
    }
}
