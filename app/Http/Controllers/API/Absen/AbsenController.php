<?php

namespace App\Http\Controllers\API\Absen;


use App\Models\Absen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    public function store(Request $request)
	{
		Absen::create([
			'agenda_id' => $request->agenda_id,
			'status' => $request->status,
			'keterangan' => $request->keterangan,
			'disposisi' => $request->disposisi,
		]);

		return response()->json([
			'message' => 'anda telah absen',
			'status' => true,
			'data' => [
				'agenda_id' => $request->agenda_id,
				'status' => $request->status,
				'keterangan' => $request->keterangan,
				'disposisi' => $request->disposisi,
			]
		]);
	}
}
