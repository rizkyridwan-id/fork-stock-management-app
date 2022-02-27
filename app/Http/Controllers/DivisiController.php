<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelDivisi;
use DataTables;
class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datamaster.datadivisi.index');
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
            'kode_divisi' => 'required',
            'nama_divisi' => 'required',
         ]);
        $cek = ModelDivisi::where('kode_divisi', '=', $request->get('kode_divisi'))->get();
        if(count($cek) == 1){
            $response = array(
                'status' => 'error',
                'pesan' =>"Kode ".$request->get('kode_divisi') .'  Tersebut Sudah Ada'
            );
            return response()->json($response, 500);
        }else{
            $simpan = ModelDivisi::create([
                'kode_divisi' => $request->get('kode_divisi'),
                'nama_divisi' => $request->get('nama_divisi'),
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
        $cek = ModelDivisi::where('id', '=', $id)->get();
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
        $cek = ModelDivisi::where('kode_divisi', $request->get('kode_divisi'))
        ->update([
            'nama_divisi' => $request->get('nama_divisi'),
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
        $hasil = ModelDivisi::where('id', $id)->delete();
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
            $datas = ModelDivisi::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function($row){  
                    $enc_id = \Crypt::encrypt($row->id);
                    $btn = '<a class="edit btn btn-sm btn-primary" onclick="showModalEditDivisi('.$row->id.')"> <i class="fas fa-edit"></i> Edit</a>
                            <a onclick="hapusDataDivisi('.$row->id.')" class="hapus btn btn-sm btn-danger"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn; 
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }

    public function dataDivisiAjax(Request $request)
    {
        $search = $request->search;

        if($search == ''){
           $supplier = ModelDivisi::orderby('nama_divisi','asc')->select('kode_divisi','nama_divisi')->limit(5)->get();
        }else{
           $supplier = ModelDivisi::orderby('nama_divisi','asc')->select('kode_divisi','nama_divisi')->where('nama_divisi', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($supplier as $row){
           $response[] = array(
                "id"=>$row->kode_divisi,
                "text"=>$row->kode_divisi .' - '. $row->nama_divisi
           );
        }
  
        return response()->json($response);
    	
    }
}
