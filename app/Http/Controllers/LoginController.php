<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function checklogin(Request $request)
    {
        $cek = User::where('username', $request->get('username'))->first();
        if($cek){
            if(password_verify($request->get('password'), $cek->password)) {
                \Session::put('datauser', $cek);
                return redirect('/dashboard');
            }else{
                return redirect()->route('login')->with('info', 'Password Salah.');
            }
        }else{
            return redirect()->route('login')->with('info', 'Username dan password tidak terfaftar.');
        }
    }

    public function logout()
    {
        \Session::forget('datauser') ;
        return redirect('/');
    }
}
