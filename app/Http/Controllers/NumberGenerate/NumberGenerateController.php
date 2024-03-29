<?php

namespace App\Http\Controllers\NumberGenerate;

use Carbon\Carbon;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NumberGenerateController extends Controller
{
    public function generate(Request $request){
        $data = null;
        if(!isset($request->prefix) || $request->prefix == null){
            return response()->json([
                'status' => 'error',
                'data' => '',
                'message' => 'query prefix harus ada'
            ]);
        }else{
            $pref = $request->prefix;
            if ($pref == 'DISPOSISI') {
				$data = [
					'class' => Disposisi::class,
					'field' => 'no_surat',
					'prefix' => $pref
				];
			}else{
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'prefix tidak valid'
                ]);
            }
        }
        return response()->json([
            'number' => $this->generateNumber($data)
        ]);
    }

    public function validateNumber(Request $request){
        if(!isset($request->prefix) || $request->prefix == null){
            return response()->json([
                'status' => 'error',
                'data' => '',
                'message' => 'query prefix harus ada'
            ]);
        }
        
        if(!isset($request->number) || $request->number == null){
            return response()->json([
                'status' => 'error',
                'data' => '',
                'message' => 'query number harus ada'
            ]);
        }
        $pref = $request->prefix;
        $params = null;

        $success = [
            'status' => 'success',
            'message' => 'nomor dapat digunakan'
        ];

        $error = [
            'status' => 'error',
            'message' => 'Nomor tidak dapat digunakan'
        ];

        if($pref == 'PB'){
            $data = RequestMaterials::whereNumber($request->number)->first();
            $params = ($data == null) ? $success : $error;
            
        } else if ($pref == 'PBO') {
            $data = RequestOfOtherMaterials::whereNumber($request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'SPK') {
            $data = SpkProjects::whereNumber($request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'BPB') {
            $data = ReceiptOfGoodsRequest::whereNumber($request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'BkPB') {
            $data = PurchaseOrderDeliveries::where('bpb_number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'SJ') {
            $data = DeliveryOrders::where('number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'PO') {
            $data = PurchaseOrders::where('number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'JU') {
            $data = AccountingJournal::where('ref' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'PK') {
            $data = AccountingJournal::where('ref' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'PU') {
            $data = WageSubmission::where('number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        } else if ($pref == 'DE') {
            $data = Debt::where('number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        }else if($pref == 'FS'){
            $data = FinancialSubmission::where('number' ,$request->number)->first();
            $params = ($data == null) ? $success : $error;
        }else{
            $params = [
                'status' => 'error',
                'message' => 'prefix tidak ditemukan'
            ];
        }

        return response()->json($params);
    }

    private function generateNumber($params){
        $now = Carbon::now();
        $prefixSize = (strlen($params['prefix']))+10;
        
        $prefix = $params['prefix'];
        $prefix .= $now->year.sprintf('%02d', $now->month);
         
        $data = $params['class']::whereRaw('LENGTH('.$params['field'].') = ?' ,$prefixSize)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where($params['field'], 'like', $prefix.'%')
            ->orderBy('created_at', 'DESC')
            ->first();

        if($data == null){
            $prefix .= sprintf('%04d', 1); 
        }else{
            $repeat = true;
            $last = substr($data[$params['field']], -4);
            $new = sprintf('%04d',++$last);
            while($repeat){
                $data = $params['class']::where($params['field'], $prefix.$new)->first();
                if($data == null){
                    $repeat = false;
                    $prefix .= sprintf('%04d',$new);
                }else{
                    $new++;
                }
            }
        }
        return $prefix;
    }
}
