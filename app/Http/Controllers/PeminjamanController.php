<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get siswa
        $peminjamans = Peminjaman::latest()->paginate(5);

        //render view with siswa
        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $siswa = Siswa::all();
        $barang = Barang::all();
        return view('peminjaman.create', compact('siswa', 'barang'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        //validate form
         $this->validate($request, [
             'id_siswa'     => 'required',
             'id_barang'     => 'required',
             'tgl_pinjam'     => 'required|date',
             'tgl_kembali'     => 'required|date',
    ]);


        $peminjaman->create([
            'id_siswa'=>$request->id_siswa,
            'id_barang'=>$request->id_barang,
            'tgl_pinjam'=>$request->tgl_pinjam,
            'tgl_kembali'=>$request->tgl_kembali,
        ]);

        // dd($Murid);

        //redirect to index
        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

     /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit(Peminjaman $peminjaman)
    {
        $siswa = Siswa::all();
        $barang = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'siswa', 'barang'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //validate form
        $this->validate($request, [
            'id_siswa'     => 'required',
            'id_barang'     => 'required',
            'tgl_pinjam'     => 'required',
            'tgl_kembali'     => 'required',
        ]);

        $data = [
            'id_siswa'=>$request->id_siswa,
            'id_barang'=>$request->id_barang,
            'tgl_pinjam'=>$request->tgl_pinjam,
            'tgl_kembali'=>$request->tgl_kembali,
        ];

        $peminjaman->update([
        'id_siswa'=>$request->input('id_siswa'),
        'id_barang'=>$request->input('id_barang'),
        'tgl_pinjam'=>$request->input('tgl_pinjam'),
        'tgl_kembali'=>$request->input('tgl_kembali'),
        ]);

        //redirect to index
        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        //redirect to index
        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
