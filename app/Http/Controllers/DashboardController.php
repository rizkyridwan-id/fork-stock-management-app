<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelBarang;
use App\Models\ModelPenerimaanBarangController;
use App\Models\ModelPengeluaranBarangController;
class DashboardController extends Controller
{
    
    public function index()
    {
        $databarang = ModelBarang::all();
        $dataterimabarang = ModelPenerimaanBarangController::where('tgl_terima', '=', date('Y-m-d'))->get();
        $datapengeluaranbarang = ModelPengeluaranBarangController::where('tgl_keluar', '=', date('Y-m-d'))->get();

        $data = array(
            'databarang' => count($databarang),
            'databarangterima' => count($dataterimabarang),
            'datapengeluaranbarang' => count($datapengeluaranbarang),
        );

        return view('dashboard.index',compact('data'));
    }
}
