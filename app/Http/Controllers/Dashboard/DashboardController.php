<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Traits\ConvertDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	use ConvertDate;

    public function index()
	{
		$now = Carbon::now();
		$period = CarbonPeriod::create($now->translatedFormat('Y-m-d'), $now->addDays(7)->translatedFormat('Y-m-d'));
		$dates = [];
		foreach($period as $date){
			array_push($dates, $date->translatedFormat('d F Y'));
		}
		$columns = [
			'file'	=> '<th>File</th>',
			'jam'	=> '<th>Jam</th>',
			'kegiatan'	=> '<th>Agenda</th>',
			'tempat'	=> '<th>Tempat</th>',
			'pelaksana_kegiatan'	=> '<th>Pelaksana</th>',
			'status'	=> '<th>Status</th>'
		];
		return view('dashboard.index', [
			'dates' => $dates,
			'columns' => $columns
		]);
	}

	public function datatables(Request $request)
	{
		$users = Agenda::whereDate('tanggal_mulai', $this->convertDate($request->date))->get();
        $datatables = datatables($users)
		->addIndexColumn()
		->addColumn('file', function($row){
			$btn = '<form action="'.route('agenda.download').'" class="d-inline mr-2" target="_blank" method="POST">';
			$btn .= ' ' . csrf_field().' ';
			$btn .= '	<input type="hidden" value="'.$row->materi.'" name="file">';
			$btn .= '	<button class="btn btn-primary btn-sm text-white">Download Materi</button>';
			$btn .= '</form>';
			return $btn;
		})
		
		->addColumn('status', function($row){
			return 'status';
		})
		->addColumn('jam', function($row){
			return $row->jam_mulai . ' - ' . ($row->jam_selesai ?? 'Selesai');
		})
		->rawColumns(['file']);
        return $datatables->toJson();
	}

}
