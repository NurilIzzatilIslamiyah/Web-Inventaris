<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    function index()
    {
        return view("sesi/index");
    }

    function login( Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
        ], [
            'email.required'=> 'Email wajib diisi',
            'password.required'=> 'Password wajib ',
            ]);

    $infologin = [
        'email' => $request->email,
        'password'=> $request->password,
    ];

    if (Auth::attempt($infologin)) {
      return redirect('siswa')->with('success', 'Berhasil login');
    } else {
      return redirect('sesi')->withErrors('Username dan passsword yang dimasukkan tidak valid');

    }


}
function logout( Request $request ) {
    Auth::logout();
    return redirect('sesi')->with('success','Berhasil Logout');
}

function register()
{
 return view('sesi/register');
}
function create(Request $request)
{
    Session::flash('name', $request->name);
    Session::flash('email', $request->email);
    $request->validate([
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
        'password'=> 'required',
    ], [
        'name.required'=> 'Nama Wajib diisi',
        'email.required'=> 'Email wajib diisi',
        'email.email'=> 'Silahkan masukkan email yang valid',
        'email.unique'=> 'Email sudah pernah digunakan, silahkan pilih email yang lain',
        'password.required'=> 'Password wajib ',
        'password.min'=> 'Minimum password yang diizinkan adalah 6 karakter',
        ]);

        $data = [
            'name' =>$request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password),

        ];

        User::create($data);

$infologin = [
    'email' => $request->email,
    'password'=> $request->password,
];

if (Auth::attempt($infologin)) {
  return redirect('siswa')->with('success', Auth::user()->name . 'Berhasil login');
} else {
  return redirect('sesi')->withErrors('Username dan passsword yang dimasukkan tidak valid');

}

 }
}
