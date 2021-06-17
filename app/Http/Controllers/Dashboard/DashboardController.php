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
		$results = [];
		foreach($period as $date){
			$count = Agenda::whereDate('tanggal_mulai', $date->format('Y-m-d'))->count();
			$item = [
				'count' => $count,
				'date' => $date->translatedFormat('d F Y')
			];
			array_push($results, $item);
		}
		return view('dashboard.index', [
			'results' => $results,
		]);
	}

	public function datatables(Request $request)
	{
		$users = Agenda::whereDate('tanggal_mulai', $this->convertDate($request->date))->get();
        $datatables = datatables($users)
		->addIndexColumn()
		->addColumn('file_materi', function($row){
			if($row->materi){
				$btn = '<form action="'.route('agenda.download').'" class="d-inline mr-2" target="_blank" method="POST">';
				$btn .= ' ' . csrf_field().' ';
				$btn .= '	<input type="hidden" value="'.$row->materi.'" name="file">';
				$btn .= '	<button class="btn btn-primary btn-sm text-white">Download</button>';
				$btn .= '</form>';
			}else{
				$btn = '-';
			}
			return $btn;
		})

		->addColumn('file_undangan', function($row){
			if($row->undangan){
				$btn = '<form action="'.route('agenda.download').'" class="d-inline mr-2" target="_blank" method="POST">';
				$btn .= ' ' . csrf_field().' ';
				$btn .= '	<input type="hidden" value="'.$row->undangan.'" name="file">';
				$btn .= '	<button class="btn btn-primary btn-sm text-white">Download</button>';
				$btn .= '</form>';
			}else{
				$btn = '-';
			}
			return $btn;
		})
		
		->addColumn('status', function($row){
			return $row->absens()->count() ? '<i class="fas fa-notification></i>' : '-';
		})
		->addColumn('jam', function($row){
			return Carbon::parse($row->jam_mulai)->format('H:i') . ' - ' . $row->jam_selesai ?? 'Selesai';
		})
		->addColumn('disposisi', function($row){
			return $row->user->name;
		})
		->rawColumns(['file_materi', 'file_undangan']);
        return $datatables->toJson();
	}

}
