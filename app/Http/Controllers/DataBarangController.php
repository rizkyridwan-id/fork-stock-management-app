<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelBarang;
use App\Models\ModelSupplier;
use DataTables;
use DB;
class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datasupplier = ModelSupplier::take(5)->get();
        return view('datamaster.databarang.index',compact('datasupplier'));
        
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
        $cek = ModelBarang::where('kode_barang', '=', $request->get('kode_barang'))->get();
        if(count($cek) == 1){
            $response = array(
                'status' => 'error',
                'pesan' =>"Kode ".$request->get('kode_barang') .'  Tersebut Sudah Ada'
            );
            return response()->json($response, 500);
            
        }else{
            $cekData = ModelBarang::max('kode_barang');
            if($cekData){
                $urutan = (int) substr($cekData, 3, 3);
                $urutan++;
                $kode_barang = 'BRG'. sprintf("%03s", $urutan);
            }else{
                $kode_barang = "BRG001";
            }
            $harga_satuan = str_replace('.', '', $request->get('harga_satuan'));
            $simpan = ModelBarang::create([
                'kode_supplier' => $request->get('kode_supplier'),
                'kode_barang' => $kode_barang,
                'nama_barang' => $request->get('nama_barang'),
                'stock' => $request->get('stock'),
                'harga_satuan' => (int)$harga_satuan,
                'keterangan_barang' => $request->get('keterangan_barang'),
            ]);
            if($simpan){
                $response = array(
                    'status' => 'berhasil',
                );
                return response()->json($response, 200);

            }else{
                $response = array(
                    'status' => 'gagal',
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
        $cek = ModelBarang::where('id', '=', $id)->get();
        if($cek){
            $response = array(
                'status' => 'berhasil',
                'data' => $cek
            );
            return response()->json($response, 200);

        }else{
            $response = array(
                'status' => 'gagal',
                'pesan' => "Gagal Mengambil Data"
            );
        return response()->json($response, 404);
        }
    }

    public function getBarangSupplier(Request $request)
    {

        $supplier = ModelBarang::orderby('nama_barang','asc')->select('kode_barang','nama_barang')->where('kode_supplier', '=', $request->get('kode_supplier'))->get();
  
        $response = array();
        foreach($supplier as $row){
           $response[] = array(
                "id"=>$row->kode_barang,
                "text"=>$row->kode_barang . " - " . $row->nama_barang
           );
        }
  
        return response()->json($response);
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
        $harga_satuan = str_replace('.', '', $request->get('harga_satuan'));
        $cek = ModelBarang::where('kode_barang', $request->get('kode_barang'))
        ->update([
            'nama_barang' => $request->get('nama_barang'),
            'kode_supplier' => $request->get('kode_supplier'),
            'stock' => $request->get('stock'),
            'harga_satuan' => (int)$harga_satuan,
            'keterangan_barang' => $request->get('keterangan_barang'),
         ]);
         if($cek){
             $response = array(
                 'status' => 'berhasil',
                 'data' => $cek
             );
             return response()->json($response, 200);
 
         }else{
             $response = array(
                 'status' => 'gagal',
                 'pesan' => "Gagal Mengambil Data"
             );
         return response()->json($response, 404);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hasil = ModelBarang::where('id', $id)->delete();
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

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $datas = ModelBarang::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function($row){  
                    $enc_id = \Crypt::encrypt($row->id);
                    $btn = '<a class="edit btn btn-sm btn-primary" onclick="showModalEditDataBarang('.$row->id.')"> <i class="fas fa-edit"></i> Edit</a>
                            <a onclick="hapusDataBarang('.$row->id.')" class="hapus btn btn-sm btn-danger" > <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn; 
                })
                ->editColumn('harga_satuan', function ($data) {
                    return number_format($data->harga_satuan, 0);
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }

    public function datasupplierAjax(Request $request)
    {
        $search = $request->search;

        if($search == ''){
           $supplier = ModelSupplier::orderby('nama_supplier','asc')->select('kode_supplier','nama_supplier')->limit(5)->get();
        }else{
           $supplier = ModelSupplier::orderby('nama_supplier','asc')->select('kode_supplier','nama_supplier')->where('nama_supplier', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($supplier as $row){
           $response[] = array(
                "id"=>$row->kode_supplier,
                "text"=>$row->kode_supplier ." - ". $row->nama_supplier
           );
        }
  
        return response()->json($response);
    	
    }
    public function dataBarangAjax(Request $request)
    {
        $search = $request->search;

        if($search == ''){
           $supplier = ModelBarang::orderby('nama_barang','asc')->select('kode_barang','nama_barang')->limit(5)->get();
        }else{
           $supplier = ModelBarang::orderby('nama_barang','asc')->select('kode_barang','nama_barang')->where('nama_barang', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($supplier as $row){
           $response[] = array(
                "id"=>$row->kode_barang,
                "text"=>$row->kode_barang .' - '. $row->nama_barang
           );
        }
  
        return response()->json($response);
    	
    }
  
}
