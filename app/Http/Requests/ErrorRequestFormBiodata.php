<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErrorRequestFormBiodata extends FormRequest
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
            'nama'  => 'required',
            'email' => 'required|regex: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',
            'no_telp'=> 'required|regex: /^[0-9,+]{9,}$/',
            'pesan' => 'required',
            'alamat'=> 'required'
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Tidak boleh kosong!',
            'email.required'=> 'Tidak boleh kosong!',
            'email.regex'   => 'Email harus mengandung @,.domain',
            'no_telp.required' => 'Tidak boleh kosong!',
            'no_telp.regex'  => 'Harus berupa angka!',
            'pesan.required'  => 'Tidak boleh kosong!',
            'alamat.required' => 'Tidak boleh kosong!'
        ];
    }
}
