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
        return view('pengeluaranbarang.index', compact('divisi'));
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
        if ($cekData[0]->stock === 0) {
            $response = array(
                'status' => 'error',
                'data' => "Stock Barang ini sudah habis"
            );
            return response()->json($response, 401);
        }
        if ($request->get('jumlah') > $cekData[0]->stock) {
            $response = array(
                'status' => 'error',
                'data' => "Tidak Boleh Melebihi Stock Barang yang tersedia"
            );
            return response()->json($response, 401);
        }
        $stockbaru = $cekData[0]->stock - $request->get('jumlah');
        $updatebarang = ModelBarang::where('kode_barang', $request->get('kode_barang'))
            ->update([
                'stock' => $stockbaru,
            ]);

        $cekNoPenerimaan = ModelPengeluaranBarangController::max('no_pengeluaran');

        if ($cekNoPenerimaan) {
            $urutan = (int) substr($cekNoPenerimaan, 3, 3);
            $urutan++;
            $no_pengeluaran = 'TRX' . sprintf("%03s", $urutan);
        } else {
            $no_pengeluaran = "TRX001";
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
        if ($simpan) {
            $response = array(
                'status' => 'berhasil',
                'data' => $simpan
            );
            return response()->json($response, 200);
        } else {
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
    public function laporanpalingbanyak()
    {
        return view('laporan.laporanbarangpalingbanyak');
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
            ->select('pb.jumlah', 'pb.tgl_keluar', 'pb.username', 'pb.no_pengeluaran', 'brg.kode_barang', 'brg.nama_barang', 'dv.kode_divisi', 'dv.nama_divisi', 'pb.keterangan', 'brg.harga_satuan')
            ->whereBetween('pb.tgl_keluar', [$request->get('tgl_dari'),  $request->get('tgl_sampai')])
            ->get();

        $data['tanggal_dari'] = $request->get('tgl_dari');
        $data['tanggal_sampai'] = $request->get('tgl_sampai');

        $pdf = PDF::loadview('laporan.cetakLpaoranPengeluaranbarang', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function generatePDFPengeluaranBarangPalingBanyak(Request $request)
    {
        $data['data'] = DB::select('SELECT count(b.kode_barang) as total, sum(b.jumlah) as jumlah_brg, a.kode_barang, a.nama_barang from tbl_barang as a INNER JOIN tbl_pengeluaran_barang AS b ON a.kode_barang = b.kode_barang WHERE b.tgl_keluar BETWEEN "'.$request->get('tgl_dari').'" and "'.$request->get('tgl_sampai').'"  group by a.kode_barang, a.nama_barang order by total desc ');
   
        $data['tanggal_dari'] = $request->get('tgl_dari');
        $data['tanggal_sampai'] = $request->get('tgl_sampai');

        $pdf = PDF::loadview('laporan.cetakLaporanPalingBanyak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
