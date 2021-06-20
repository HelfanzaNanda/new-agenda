<?php

namespace App\Http\Controllers\Report\Agenda;

use Carbon\Carbon;
use App\Models\Agenda;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
	public $months = [
		'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli ', 'Augustus', 'September', 'Oktober', 'November', 'Desember',
	];
    public function index()
	{

		$startYear = Carbon::create('2007')->format('Y');
		$nowYear = Carbon::now()->format('Y');		
		$years = [];
		for ($i= $startYear; $i <= $nowYear; $i++) { 
			array_push($years, $i);	
		}

		$selected_month = Carbon::now()->translatedFormat('F');
		$selected_year = Carbon::now()->translatedFormat('Y');
		return view('report.agenda.index', [
			'selected_month' => $selected_month,
			'selected_year' => $selected_year,
			'years' => $years,
			'months' => $this->months
		]);
	}

	public function datatables(Request $request)
	{
		$query = Agenda::query()
				->whereMonth('tanggal_mulai', now()->format('m'))
				->whereYear('tanggal_mulai', now()->format('Y'));
		if($request->month){
			$query->whereMonth('tanggal_mulai', $request->month);
		}
		if($request->year){
			$query->whereYear('tanggal_mulai', $request->year);
		}
		$agendas = $query->get();
		
        $datatables = datatables($agendas)
		->addIndexColumn()
		->addColumn('h/t', function($row){
			return $row->tanggal_mulai->translatedFormat('l, d F Y') . ' <b>s.d</b> ' . $row->tanggal_selesai->translatedFormat('l, d F Y');
		})
		->addColumn('jam', function($row){
			return Carbon::parse($row->jam_mulai)->format('H:i') . ' - ' . ($row->jam_selesai ?? 'Selesai');
		})
		->addColumn('hadir', function($row){
			return $row->daftar_hadirs()->count() ? 'Hadir' : 'Diwakili';
		})
		->rawColumns(['h/t']);
		
        return $datatables->toJson();
	}

	public function pdf(Request $request)
	{
		$query = Agenda::query()
				->whereMonth('tanggal_mulai', now()->format('m'))
				->whereYear('tanggal_mulai', now()->format('Y'));
		if($request->month){
			$query->whereMonth('tanggal_mulai', $request->month);
		}
		if($request->year){
			$query->whereYear('tanggal_mulai', $request->year);
		}
		$agendas = $query->get();
		return view('report.agenda.pdf', [
			'agendas' => $agendas,
			'selected_month' => $request->month ? $this->months[$request->month] : now()->format('F'),
			'selected_year' => $request->year ?? now()->format('Y'),
		]);
	}
}
