<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $guarded = [];

	public $dates = [
		'tanggal'
	];

	public const DIKONFIRMASI = "Dikonfirmasi";
	public const BELUMDIKONFIRMASI = "Belum Dikonfirmasi";

	public function lampirans()
	{
		return $this->hasMany(Lampiran::class);
	}

	public function dari()
	{
		return $this->belongsTo(User::class, 'dari_id');
	}

	public function kepada()
	{
		return $this->belongsTo(User::class, 'kepada_id');
	}

	public function agenda()
	{
		return $this->belongsTo(Agenda::class);
	}
}
