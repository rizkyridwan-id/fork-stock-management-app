<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelBarang;
class DashboardController extends Controller
{
    
    public function index()
    {
        $databarang = ModelBarang::all();
        $data = array(
            'databarang' => count($databarang),
        );
        return view('dashboard.index',compact('data'));
    }
}
