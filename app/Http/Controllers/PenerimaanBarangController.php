<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelBarang;
use App\Models\ModelSupplier;
use App\Models\ModelPenerimaanBarangController;

use PDF;
use DataTables;
use Session;
use DB;
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

            $cekNoPenerimaan = ModelPenerimaanBarangController::max('no_penerimaan');
         
            if($cekNoPenerimaan){
                $urutan = (int) substr($cekNoPenerimaan, 3, 3);
                $urutan++;
                $no_penerimaan = 'TRX'. sprintf("%03s", $urutan);
            }else{
                $no_penerimaan = "TRX001";
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
    public function deletePenerimaanBarang(Request $request)
    {
        $cekData = ModelBarang::where('kode_barang', '=', $request->get('kode_barang'))->get();
        $stockbaru = $cekData[0]->stock - $request->get('stock');
        $updatebarang = ModelBarang::where('kode_barang', $request->get('kode_barang'))
        ->update([
            'stock' => $stockbaru,
        ]);

        $hasil = ModelPenerimaanBarangController::where('id', $request->get('id'))->delete();
        if($hasil){
             $response = array(
                 'status' => 'berhasil',
                 'pesan' =>'Data Berhasil Di hapus'
             );
             return response()->json($response, 200);
         }else{
             $response = array(
                 'status' => 'error',
                 'pesan' =>'Data Gagal Di hapus'
             );
             return response()->json($response, 200);
         }


    }

    public function laporan()
    {
        return view('laporan.LaporanPenerimaanBarang');
        
    }

    public function generatePDFPenerimaanBarang(Request $request)
    {
        $data['data'] = DB::table('tbl_penerimaan_barang as pb')
        ->join('tbl_barang as brg', 'pb.kode_barang', '=', 'brg.kode_barang')
        ->select('pb.stock','pb.tgl_terima','pb.username','pb.no_penerimaan','brg.kode_barang','brg.nama_barang','brg.harga_satuan')
        ->whereBetween('pb.tgl_terima',[ $request->get('tgl_dari'),  $request->get('tgl_sampai')])
        ->get();

        $pdf = PDF::loadview('laporan.cetakLaporanPenerimaanbarang', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $datas = ModelPenerimaanBarangController::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function($row){  
                    $enc_id = \Crypt::encrypt($row->id);
                    $btn = '<a onclick="hapusPenerimaanBarang(this)" data-id="'.$row->id.'" data-kode_barang="'.$row->kode_barang.'"  data-stock="'.$row->stock.'"  class="hapus btn btn-sm btn-danger" > <i class="fas fa-trash"></i> Hapus</a>';
                    return date('Y-m-d') === $row->tgl_terima ?  $btn : 'Tidak Bisa  Mengapus Penerimaan Barang Kemarin'; 
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }

}
