<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Masuk;
use App\Models\Parkir;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('masuk')
        ->join('parkir', 'parkir.id_parkir', '=', 'masuk.parkir_id')
        ->get(['parkir.blok', 'masuk.no_plat', 'masuk.jenis',
        'masuk.created_at']);

        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        try {
            $request->validate([
                'parkir_id'=> 'required',
                'no_plat' => 'required',
                'jenis' => 'required'
            ]);

            $masuk = Masuk::create([
                'parkir_id' => $request->parkir_id,
                'no_plat' => $request->no_plat,
                'jenis' => $request->jenis,
                'slot' => '1',
                'terisi' => '0'
            ]);
            $masuk->save();

            $parkir = Parkir::find($request->parkir_id);
            
            $parkir->update(["tersedia"=>(int) $parkir->value('tersedia') - (int) $masuk->value('slot')]);
            $parkir->update(["terisi"=>(int) $parkir->value('terisi') + (int) $masuk->value('slot')]);
        
            $parkir->save();
            
            $data = Masuk::where('id', $masuk->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
