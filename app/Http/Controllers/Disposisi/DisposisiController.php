<?php

namespace App\Http\Controllers\Disposisi;

use App\Models\Agenda;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Disposisi\CreateRequest;
use App\Http\Requests\Disposisi\UpdateRequest;
use App\Traits\{UploadFile, GetDisposisi, ConvertDate};

class DisposisiController extends Controller
{
    use ConvertDate, UploadFile, GetDisposisi;
    
	public function index()
	{
		return view('disposisi.index');
	}

	public function create($agenda_id = null)
	{
		$agendas = Agenda::get();
		$users = $this->getDisposisi();
		return view('disposisi.create', [
			'agenda_id' => $agenda_id,
			'agendas' => $agendas,
			'users' => $users
		]);
	}

	public function edit($id)
	{
		$disposisi = Disposisi::whereId($id)->first();
		$agendas = Agenda::get();
		$users = $this->getDisposisi();
		return view('disposisi.edit', [
			'users' => $users,
			'agendas' => $agendas,
			'disposisi' => $disposisi,
		]);
	}

	public function detail($id)
	{
		$disposisi = Disposisi::with('lampirans', 'dari', 'kepada', 'agenda')->whereId($id)->first();
		$disposisi['tanggal_format'] = $disposisi->tanggal->translatedFormat('d F Y');
		return $disposisi;
	}

	public function store(CreateRequest $request)
	{
		$surat = $request->file('surat') ?  $this->uploadFile($request->file('surat'), 'disposisi') : null;
		$disposisi = Disposisi::create([
			'no_surat' => $request->no_surat,
			'tanggal' => $this->convertDate($request->tanggal),
			'dari_id' => $request->dari,
			'kepada_id' => $request->kepada,
			'agenda_id' => $request->agenda,
			'perihal' => $request->perihal,
			'catatan' => $request->catatan,
			'file_surat' => $surat,
			'status' => Disposisi::DIKONFIRMASI,
		]);
		
		if($request->lampiran){
			foreach($request->lampiran as $key => $lampiran){
				$disposisi->lampirans()->create([
					'filename' => $this->uploadFile($lampiran, 'lampiran'),
					'name' => 'Lampiran'. ($key+1)
				]);
			}
		}
		
		return response()->json([
			'message' => 'berhasil menambahkan data'
		]);
	}

	public function update(UpdateRequest $request, $id)
	{
		$disposisi = Disposisi::whereId($id)->first();
		$surat = $request->file('surat') ?  $this->uploadFile($request->file('surat'), 'disposisi') : $disposisi->file_surat;
		$disposisi->update([
			//'no_surat' => $request->no_surat,
			'tanggal' => $this->convertDate($request->tanggal),
			'dari_id' => $request->dari,
			'kepada_id' => $request->kepada,
			'agenda_id' => $request->agenda,
			'perihal' => $request->perihal,
			'catatan' => $request->catatan,
			'file_surat' => $surat,
			'status' => Disposisi::DIKONFIRMASI,
		]);
		
		if($request->lampiran){
			$disposisi->lampirans()->delete();
			foreach($request->lampiran as $key => $lampiran){
				$disposisi->lampirans()->create([
					'filename' => $this->uploadFile($lampiran, 'lampiran'),
					'name' => 'Lampiran'. ($key+1)
				]);
			}
		}

		return response()->json([
			'message' => 'berhasil update data'
		]);
	}

	public function datatables(Request $request)
	{
		$query = Disposisi::query();
		

		$disposisies = $query->get();
		
        $datatables = datatables($disposisies)
		->addIndexColumn()
		->addColumn('tanggal', function($row){
			return $row->tanggal->format('d/m/Y');
		})
		->addColumn('dari', function($row){
			return $row->dari->name;
		})
		->addColumn('kepada', function($row){
			return $row->kepada->name;
		})
		->addColumn('agenda', function($row){
			return $row->agenda->kegiatan;
		})
		->addColumn('lampiran', function($row){
			return $row->lampirans()->get()->implode('name', ',');
		})
		
        ->addColumn('_buttons', function($row){
			$btn = '';
			$btn .= '<div class="btn-group" role="group">';
			if($row->file_surat){
				$btn .= '	<a data-file="'.$row->file_surat.'"  class="btn-download btn btn-sm btn-primary text-white"><i class="fas fa-download"></i></a>';
			}
			$btn .= '	<a data-id="'.$row->id.'"  class="btn-detail btn btn-sm btn-primary text-white"><i class="fas fa-eye"></i></a>';
            $btn .= '	<a  href="'.route('disposisi.edit', $row->id).'" class="btn-edit btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i></a>';
            $btn .= '	<a data-id="'.$row->id.'" class="btn-delete btn btn-sm text-white btn-danger"><i class="fa fa-trash"></i></a>';
			$btn .= '</div>';
            
            return $btn;
        })
        ->rawColumns(['_buttons']);
        return $datatables->toJson();
	}

	public function delete($id)
	{
		$disposisi = Disposisi::whereId($id)->first();
		$disposisi->delete();

		return response()->json([
			'message' => 'berhasil delete data'
		]);
	}

	public function download(Request $request)
	{
		$file = $request->file;
		return response()->download($file);
	}

	public function get(Request $request)
	{
		if($request->type == 'pelaksana'){
			return Agenda::where('pelaksana_kegiatan', 'like', '%' . $request->key . '%')->get()->pluck('pelaksana_kegiatan');
		}elseif($request->type == 'disposisi'){
			return Agenda::with('user')
			->whereHas('user', function($q) use($request){
				$q->where('name', 'like', '%'. $request->key. '%');
			})->get();
		}
	}

	public function generateNumber()
	{
		return $this->generate("DISPOSISI");
	}
}
