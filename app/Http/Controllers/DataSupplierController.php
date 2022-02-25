<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelSupplier;
use DataTables;
class DataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datamaster.datasupplier.index');
        
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
        $this->validate($request,[
            'kode_supplier' => 'required',
            'nama_supplier' => 'required',
         ]);
        $cek = ModelSupplier::where('kode_supplier', '=', $request->get('kode_supplier'))->get();
        if(count($cek) == 1){
            $response = array(
                'status' => 'error',
                'pesan' =>"Kode ".$request->get('kode_supplier') .'  Tersebut Sudah Ada'
            );
            return response()->json($response, 500);
        }else{
            $simpan = ModelSupplier::create([
                'kode_supplier' => $request->get('kode_supplier'),
                'nama_supplier' => $request->get('nama_supplier'),
            ]);
            if($simpan){
                $response = array(
                    'status' => 'berhasil',
                    'data' => $cek
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
        $cek = ModelSupplier::where('id', '=', $id)->get();
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
        $cek = ModelSupplier::where('kode_supplier', $request->get('kode_supplier'))
        ->update([
            'nama_supplier' => $request->get('nama_supplier'),
            // 'password' => bcrypt($request->get('password'))
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
        $hasil = ModelSupplier::where('id', $id)->delete();
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
            $datas = ModelSupplier::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function($row){  
                    $enc_id = \Crypt::encrypt($row->id);
                    $btn = '<a class="edit btn btn-sm btn-primary" onclick="shwoModalEditSupplier('.$row->id.')"> <i class="fas fa-edit"></i> Edit</a>
                            <a onclick="hapusDataSupplier('.$row->id.')" class="hapus btn btn-sm btn-danger" > <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn; 
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }
}
