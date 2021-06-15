<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agenda\CreateRequest;
use App\Http\Requests\Agenda\UpdateRequest;
use App\Models\Agenda;
use App\Traits\ConvertDate;
use App\Traits\UploadFile;
use App\User;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
	use ConvertDate, UploadFile;
    
	public function index()
	{
		return view('agenda.index');
	}

	public function create()
	{
		$users = User::where('is_login', true)->get();
		return view('agenda.create', [
			'users' => $users
		]);
	}

	public function edit($id)
	{
		$agenda = Agenda::whereId($id)->first();
		$agenda['daterange'] = $agenda->tanggal_mulai->format('m/d/Y') . ' - ' . $agenda->tanggal_selesai->format('m/d/Y');
		$users = User::where('is_login', true)->get();
		return view('agenda.edit', [
			'users' => $users,
			'agenda' => $agenda
		]);
	}

	public function detail($id)
	{
		$agenda = Agenda::with('documentations', 'user')->whereId($id)->first();
		$agenda['daterange'] = $agenda->tanggal_mulai->format('m/d/Y') . ' - ' . $agenda->tanggal_selesai->format('m/d/Y');
		return $agenda;
	}

	public function store(CreateRequest $request)
	{
		$params = $request->except(['date_range', 'dokumentasi', 'pelaksana', 'absen']);
		if($params['jam_selesai'] == 'Selesai'){
			$params['jam_selesai'] = null;
		}
		$params['pelaksana_kegiatan'] = $request->pelaksana;
		$params['tanggal_mulai'] = $this->convertDate(substr($request->date_range, 0, 10));
		$params['tanggal_selesai'] = $this->convertDate(substr($request->date_range, 13));
		$params['undangan'] = $this->uploadFile($request->file('undangan'), 'agendas');
		$params['materi'] = $this->uploadFile($request->file('materi'), 'agendas');
		$params['daftar_hadir'] = $this->uploadFile($request->file('absen'), 'agendas');
		$params['notulen'] = $this->uploadFile($request->file('notulen'), 'agendas');
		$agenda = Agenda::create($params);
		
		foreach($request->dokumentasi as $doc){
			$agenda->documentations()->create([
				'dokumentasi' => $this->uploadFile($doc, 'agendas')
			]);
		}
		

		return response()->json([
			'message' => 'berhasil menambahkan data'
		]);
	}

	public function update(UpdateRequest $request, $id)
	{
		$params = $request->except(['date_range', 'dokumentasi', 'pelaksana', 'absen']);
		if($params['jam_selesai'] && $params['jam_selesai'] == 'Selesai'){
			$params['jam_selesai'] = null;
		}
		$agenda = Agenda::whereId($id)->first();
		$agenda->update([
			'pelaksana_kegiatan' => $request->pelaksana ?? $agenda->pelaksana_kegiatan,
			'jam_mulai' => $request->jam_mulai ?? $agenda->jam_mulai,
			'jam_selesai' => $request->jam_selesai ?? $agenda->jam_selesai,
			'kegiatan' => $request->kegiatan ?? $agenda->kegiatan,
			'tempat' => $request->tempat ?? $agenda->tempat,
			'disposisi' => $request->disposisi ?? $agenda->disposisi,
			'undangan' => $request->file('undangan') ? $this->uploadFile($request->file('undangan'), 'agendas') : $agenda->undangan,
			'materi' => $request->file('materi') ? $this->uploadFile($request->file('materi'), 'agendas') : $agenda->materi,
			'daftar_hadir' => $request->file('absen') ? $this->uploadFile($request->file('absen'), 'agendas') : $agenda->daftar_hadir,
			'notulen' => $request->file('notulen') ? $this->uploadFile($request->file('notulen'), 'agendas') : $agenda->notulen,
		]);
		
		if($request->dokumentasi){
			$agenda->documentations()->delete();
			foreach($request->dokumentasi as $doc){
				$agenda->documentations()->create([
					'dokumentasi' => $this->uploadFile($doc, 'agendas')
				]);
			}
		}
		

		return response()->json([
			'message' => 'berhasil update data'
		]);
	}

	public function datatables(Request $request)
	{
		$agendas = Agenda::all();
        $datatables = datatables($agendas)
		->addIndexColumn()
		->addColumn('h/t', function($row){
			return $row->tanggal_mulai->translatedFormat('d F Y') . ' - ' . $row->tanggal_selesai->translatedFormat('d F Y');
		})
		->addColumn('disposisi', function($row){
			return $row->user->name;
		})
		->addColumn('status', function($row){
			return 'status';
		})
		->addColumn('jam', function($row){
			return $row->jam_mulai . ' - ' . ($row->jam_selesai ?? 'Selesai');
		})
        ->addColumn('_buttons', function($row){
			$btn = '';
			$btn .= '<form action="'.route('agenda.download').'" class="d-inline mr-2" target="_blank" method="POST">';
			$btn .= ' ' . csrf_field().' ';
			$btn .= '	<input type="hidden" value="'.$row->undangan.'" name="file">';
			$btn .= '	<button class="btn btn-primary text-white">Download Undangan</button>';
			$btn .= '</form>';
			
			$btn .= '<form action="'.route('agenda.download').'" class="d-inline mr-2" target="_blank" method="POST">';
			$btn .= ' ' . csrf_field().' ';
			$btn .= '	<input type="hidden" value="'.$row->materi.'" name="file">';
			$btn .= '	<button class="btn btn-primary text-white">Download Materi</button>';
			$btn .= '</form>';

            $btn .= '<a data-id="'.$row->id.'"  class="btn-detail btn btn-sm btn-primary text-white mr-2">Detail</i></a>';
            $btn .= '<a  href="'.route('agenda.edit', $row->id).'" class="btn-edit btn btn-sm btn-warning mr-2"><i class="fa fa-edit"></i></a>';
            $btn .= '<a data-id="'.$row->id.'" class="btn-delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['_buttons']);
        return $datatables->toJson();
	}

	public function delete($id)
	{
		$agenda = Agenda::whereId($id)->first();
		$agenda->delete();

		return response()->json([
			'message' => 'berhasil delete data'
		]);
	}

	public function download(Request $request)
	{
		$file = $request->file;
		return response()->download($file);
	}
}
