<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;


class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datamaster.datauser.index');
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
            'username' => 'required',
            'nama_lengkap' => 'required',
            'password' => 'required',
         ]);
        $cek = User::where('username', '=', $request->get('username'))->get();
        if(count($cek) == 1){
            $response = array(
                'status' => 'error',
                'pesan' =>"Username ".$request->get('username') .' Sudah Terdaftar'
            );
            return response()->json($response, 500);
        }else{
            $simpan = User::create([
                'username' => $request->get('username'),
                'nama_lengkap' => $request->get('nama_lengkap'),
                'password' => bcrypt($request->get('password'))
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
        $cek = User::where('id', '=', $id)->get();
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
        $cek = User::where('username', $request->get('username'))
        ->update([
            'nama_lengkap' => $request->get('nama_lengkap'),
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
        $hasil = User::where('id', $id)->delete();
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
            $datas = User::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function($row){  
                    $hidden = $row->username === "superadmin" ? "display:none" : "";
                    $btn = '<a class="edit btn btn-sm btn-primary"  onclick="showModalEditUsers('.$row->id.')"> <i class="fas fa-edit"></i> Edit</a>
                            <a onclick="hapusDtaUsers('.$row->id.')" class="hapus btn btn-sm btn-danger" style='.$hidden.'> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn; 
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        } 
    }
}
