<?php

namespace App\Http\Requests\Agenda;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'date_range' => 'required',
			'jam_mulai' => 'required',
			'jam_selesai' => 'required',
			'kegiatan' => 'required',
			'tempat' => 'required',
			'pelaksana' => 'required',
			'disposisi' => 'required',

			// 'undangan' => 'required',
			// 'materi' => 'required',
			// 'absen' => 'required',
			// 'notulen' => 'required',
			'dokumentasi' => 'array'
        ];
    }
}
