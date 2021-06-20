<?php

namespace App\Http\Requests\Disposisi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'tanggal' => 'required',
            'dari' => 'required',
            'kepada' => 'required',
            'agenda' => 'required',
            'perihal' => 'required',
            'catatan' => 'required',
            'lampiran' => 'array',
        ];
    }
}
