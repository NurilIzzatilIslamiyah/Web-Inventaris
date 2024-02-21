<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get barang
        $barang = Barang::latest()->paginate(5);

        //render view with barang
        return view('barang.index', compact('barang'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $barang = Barang::all();
        return view('barang.create', compact('barang'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'nama_barang' => 'required',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // Create a new instance of the Barang model
        $data = [
            'nama_barang' => $request->input('nama_barang'),
            'gambar' => $request->file('gambar')->hashName()
        ];

        // Upload image
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/post', $gambar->hashName());

        // Save the record to the database
        Barang::create($data);

        // Redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function edit(barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $siswa
     * @return void
     */
    public function update(Request $request, barang $barang)
    {
        //validate form
        $this->validate($request, [
            'nama_barang' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $barang->update([
            'nama_barang' => $request->input('nama'),

            'image' => $request->input('image'),
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
