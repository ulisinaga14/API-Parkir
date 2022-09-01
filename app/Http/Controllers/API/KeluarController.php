<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Keluar;
use App\Models\Parkir;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluarController extends Controller
{
    public function index()
    {
        $data = DB::table('keluar')
        ->join('parkir', 'parkir.id_parkir', '=', 'keluar.parkir_id')
        ->get(['parkir.blok', 'keluar.no_plat', 'keluar.jenis',
        'keluar.created_at']);

        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed!');
        }
    }

    public function store(Request $request)
    {    
        try {
            $request->validate([
                'parkir_id'=> 'required',
                'no_plat' => 'required',
                'jenis' => 'required'
            ]);

            $keluar = Keluar::create([
                'parkir_id' => $request->parkir_id,
                'no_plat' => $request->no_plat,
                'jenis' => $request->jenis,
                'slot' => '1'
            ]);
            $keluar->save();

            $parkir = Parkir::find($request->parkir_id);
            
            $parkir->update(["tersedia"=>(int) $parkir->value('tersedia') + (int) $keluar->value('slot')]);
            $parkir->update(["terisi"=>(int) $parkir->value('terisi') - (int) $keluar->value('slot')]);
        
        
            $parkir->save();
            
            $data = Keluar::where('id', $keluar->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}
