<?php

namespace App\Http\Controllers\API\Agenda;

use App\Http\Controllers\Controller;
use App\Http\Resources\Agenda\AgendaResource;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
	{
		$agendas = Agenda::all();
		return response()->json([
			'message' => 'get agenda',
			'status' => true,
			'data' => AgendaResource::collection($agendas)
		]);
	}

	public function detail($id)
	{
		$agenda = Agenda::whereId($id)->first();
		return response()->json([
			'message' => 'get detail',
			'status' => true,
			'data' => (new AgendaResource($agenda))->additional([
				'id_agenda' => $id,
				'undangan_url' => url($agenda->undangan),
				'materi_url' => url($agenda->materi)
			])
		]);
	}
}
