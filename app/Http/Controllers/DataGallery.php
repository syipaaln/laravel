<?php

namespace App\Http\Controllers;

use App\Models\DataGallery as ModelsDataGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataGallery extends Controller
{
    function index()
    {
        $data = ModelsDataGallery::all();
        return view('data_gallery.index', ['data' => $data]);
    }
    function tambah()
    {
        return view('data_gallery.tambah');
    }
    function edit($id)
    {
        $data = ModelsDataGallery::find($id);

        return view('data_gallery.edit', ['data' => $data]);
    }
    function hapus(Request $request)
    {
        ModelsDataGallery::where('id', $request->id)->delete();

        Session::flash('success', 'Berhasil Hapus Data');

        return redirect('/DataGallery');
    }
    // new
    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'nim' => 'required|max:8',
            'angkatan' => 'required|min:2|max:2',
            'jurusan' => 'required',
        ], [
            'name.required' => 'Name Wajib Di isi',
            'name.min' => 'Bidang name minimal harus 3 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'nim.required' => 'Nim Wajib Di isi',
            'nim.max' => 'NIM max 8 Digit',
            'angkatan.required' => 'Angkatan Wajib Di isi',
            'angkatan.min' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
            'angkatan.max' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
            'jurusan.required' => 'Jurusan Wajib Di isi',
        ]);

        ModelsDataGallery::insert([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');

        return redirect('/DataGallery')->with('success', 'Berhasil Menambahkan Data');
    }
    function change(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'nim' => 'required|min:8|max:8',
            'angkatan' => 'required|min:2|max:2',
            'jurusan' => 'required',
        ], [
            'name.required' => 'Name Wajib Di isi',
            'name.min' => 'Bidang name minimal harus 3 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'nim.required' => 'Nim Wajib Di isi',
            'nim.max' => 'NIM max 8 Digit',
            'nim.min' => 'NIM min 8 Digit',
            'angkatan.required' => 'Angkatan Wajib Di isi',
            'angkatan.min' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
            'angkatan.max' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
            'jurusan.required' => 'Jurusan Wajib Di isi',
        ]);

        $DataGallery = ModelsDataGallery::find($request->id);

        $DataGallery->name = $request->name;
        $DataGallery->email = $request->email;
        $DataGallery->nim = $request->nim;
        $DataGallery->angkatan = $request->angkatan;
        $DataGallery->jurusan = $request->jurusan;
        $DataGallery->save();

        Session::flash('success', 'Berhasil Mengubah Data');

        return redirect('/DataGallery');
    }
}
