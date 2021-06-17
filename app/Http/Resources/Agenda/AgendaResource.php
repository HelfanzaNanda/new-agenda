<?php

namespace App\Http\Resources\Agenda;

use Illuminate\Http\Resources\Json\JsonResource;

class AgendaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'tanggal_mulai' => $this->tanggal_mulai,
			'tanggal_selesai' => $this->tanggal_selesai,
			'jam_mulai' => $this->jam_mulai,
			'jam_selesai' => $this->jam_selesai,
			'kegiatan' => $this->kegiatan,
			'tempat' => $this->tempat,
			'pelaksana_kegiatan' => $this->pelaksana_kegiatan,
			'disposisi' => $this->user->name,
			'undangan' => url('/') .'/' . $this->undangan,
			'materi' => url('/') .'/' . $this->materi,
			'daftar_hadir' => url('/') .'/' . $this->daftar_hadir,
			'notulen' => url('/') .'/' . $this->notulen,
			'dokumentations' => $this->documentations,
		];
    }
}
