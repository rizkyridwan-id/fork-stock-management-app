<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelDivisi;
use App\Models\ModelPengeluaranBarangController;
use App\Models\ModelBarang;
use DataTables;
use Session;
use DB;
use PDF;

class PengeluaranBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi = ModelDivisi::take(5)->get();
        return view('pengeluaranbarang.index',compact('divisi'));
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
        $stockbaru = $cekData[0]->stock - $request->get('jumlah');
        $updatebarang = ModelBarang::where('kode_barang', $request->get('kode_barang'))
        ->update([
            'stock' => $stockbaru,
        ]);

        $cekNoPenerimaan = ModelPengeluaranBarangController::latest()->take(1)->get();
         
        if(count($cekNoPenerimaan) == 0){
            $no_pengeluaran = "TRX001";
        }else{
            $urutan = (int) substr($cekNoPenerimaan[0]->no_pengeluaran, 3, 3);
            $urutan++;
            $no_pengeluaran = 'TRX'. sprintf("%03s", $urutan);
        }
        $simpan = ModelPengeluaranBarangController::create([
            'no_pengeluaran' => $no_pengeluaran,
            'kode_barang' => $request->get('kode_barang'),
            'jumlah' => $request->get('jumlah'),
            'kode_divisi' => $request->get('kode_divisi'),
            'tgl_keluar' => date('Y-m-d'),
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
        return view('laporan.LaporanPengeluaranBarang');
        
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $datas = ModelPengeluaranBarangController::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }

    public function generatePDFPengeluaranBarang(Request $request)
    {
        $data['data'] = DB::table('tbl_pengeluaran_barang as pb')
        ->join('tbl_barang as brg', 'pb.kode_barang', '=', 'brg.kode_barang')
        ->join('tbl_divisi as dv', 'dv.kode_divisi', '=', 'pb.kode_divisi')
        ->select('pb.jumlah','pb.tgl_keluar','pb.username','pb.no_pengeluaran','brg.kode_barang','brg.nama_barang','dv.kode_divisi','dv.nama_divisi','pb.keterangan')
        ->whereBetween('pb.tgl_keluar',[ $request->get('tgl_dari'),  $request->get('tgl_sampai')])
        ->get();
        $pdf = PDF::loadview('laporan.cetakLpaoranPengeluaranbarang', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
