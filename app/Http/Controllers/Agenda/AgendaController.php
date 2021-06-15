<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Traits\ConvertDate;
use App\Traits\UploadFile;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
	use ConvertDate, UploadFile;
    public function index()
	{
		return view('agenda.index');
	}

	public function get($id)
	{
		$agenda = Agenda::whereId($id)->first();
		$agenda['daterange'] = $agenda->start_date->format('m/d/Y') . ' - ' . $agenda->end_date->format('m/d/Y');
		return $agenda;
	}

	public function createOrUpdate(Request $request)
	{
		$request->validate([
			'date_range' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'name' => 'required',
			'place' => 'required',
			'executor' => 'required',
			//'file' => 'required'
		]);

		if($request->id){
			$agenda = Agenda::whereId($request->id)->first();
		}
		$params = $request->except('date_range');
		$params['start_date'] = $this->convertDate(substr($request->date_range, 0, 10));
		$params['end_date'] = $this->convertDate(substr($request->date_range, 13));
		$params['file'] = $request->file('file') ? $this->uploadFile($request->file('file'), 'agendas') : $agenda->file;
		Agenda::updateOrCreate(['id' => $request->id], $params);

		return response()->json([
			'message' => 'berhasil menambahkan data'
		]);
	}

	public function datatables(Request $request)
	{
		$agendas = Agenda::all();
        $datatables = datatables($agendas)
		->addIndexColumn()
		->addColumn('h/t', function($row){
			return $row->start_date->translatedFormat('d F Y') . ' - ' . $row->end_date->translatedFormat('d F Y');
		})
		->addColumn('time', function($row){
			return $row->start_time . ' - ' . $row->end_time;
		})
        ->addColumn('_buttons', function($row){
            $btn = '<a data-id="'.$row->id.'" class="btn-edit btn btn-sm btn-warning mr-2"><i class="fa fa-edit"></i></a>';
            $btn .= '<a data-id="'.$row->id.'" class="btn-delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['_buttons']);
        return $datatables->toJson();
	}

	public function delete($id)
	{
		$user = Agenda::whereId($id)->first();
		$user->delete();

		return response()->json([
			'message' => 'berhasil delete data'
		]);
	}
}
