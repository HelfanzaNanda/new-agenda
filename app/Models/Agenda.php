<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $guarded = [];

	protected $dates = [
		'tanggal_mulai', 'tanggal_selesai'
	];

	public function documentations()
	{
		return $this->hasMany(DocumentationAgenda::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'disposisi', 'id');
	}

	public function daftar_hadirs()
	{
		return $this->hasMany(DaftarHadir::class, 'status');
	}
}
