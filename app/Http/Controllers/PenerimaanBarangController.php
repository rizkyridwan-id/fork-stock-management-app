<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelBarang;
use App\Models\ModelSupplier;
use App\Models\ModelPenerimaanBarangController;

use PDF;
use DataTables;
use Session;
class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $databarang = ModelBarang::take(5)->get();
        $datasupplier = ModelSupplier::take(5)->get();
        return view('penerimaanbarang.index',compact('datasupplier'));
        
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
        $cekData = ModelBarang::where('kode_barang', '=', $request->get('kode_barang'))->get();
        if(count($cekData) == 0){
            $response = array(
                'status' => 'error',
                'pesan' =>"Kode ".$request->get('kode_barang') .'  Tersebut Tidak Terdaftar'
            );
            return response()->json($response, 500);
        }else{
            $stockbaru = $cekData[0]->stock + $request->get('stock');
            $updatebarang = ModelBarang::where('kode_barang', $request->get('kode_barang'))
            ->update([
                'stock' => $stockbaru,
            ]);

            $cekNoPenerimaan = ModelPenerimaanBarangController::latest()->take(1)->get();
         
            if(count($cekNoPenerimaan) == 0){
                $no_penerimaan = "TRX001";
            }else{
                $urutan = (int) substr($cekNoPenerimaan[0]->no_penerimaan, 3, 3);
                $urutan++;
                $no_penerimaan = 'TRX'. sprintf("%03s", $urutan);
            }

            $simpan = ModelPenerimaanBarangController::create([
                'no_penerimaan' => $no_penerimaan,
                'kode_supplier' => $request->get('kode_supplier'),
                'kode_barang' => $request->get('kode_barang'),
                'tgl_terima' => $request->get('tgl_terima'),
                'stock' => $request->get('stock'),
                'username' =>  Session::get('datauser')->username,
                'keterangan' =>  $request->get('keterangan_penerima'),
            ]);
            if($simpan){
                $response = array(
                    'status' => 'berhasil',
                    'data' => $simpan
                );
                return response()->json($response, 200);

            }else{
                $response = array(
                    'status' => 'gagal',
                    'data' => $simpan
                );
            return response()->json($response, 404);
            }
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

    public function laporan()
    {
        return view('laporan.LaporanPenerimaanBarang');
        
    }

    public function generatePDFPenerimaanBarang()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        $pdf = PDF::loadview('laporan.cetakLaporanPenerimaanbarang', $data)->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
