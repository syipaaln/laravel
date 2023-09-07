<?php

namespace App\Http\Controllers;

use App\Models\DataGuru as ModelsDataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataGuru extends Controller
{
    function index()
    {
        $data = ModelsDataGuru::all();
        return view('data_guru.index', ['data' => $data]);
    }
    function tambah()
    {
        return view('data_guru.tambah');
    }
    function edit($id)
    {
        $data = ModelsDataGuru::find($id);

        return view('data_guru.edit', ['data' => $data]);
    }
    function hapus(Request $request)
    {
        ModelsDataGuru::where('id', $request->id)->delete();

        Session::flash('success', 'Berhasil Hapus Data');

        return redirect('/DataGuru');
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

        ModelsDataGuru::insert([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');

        return redirect('/DataGuru')->with('success', 'Berhasil Menambahkan Data');
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

        $DataGuru = ModelsDataGuru::find($request->id);

        $DataGuru->name = $request->name;
        $DataGuru->email = $request->email;
        $DataGuru->nim = $request->nim;
        $DataGuru->angkatan = $request->angkatan;
        $DataGuru->jurusan = $request->jurusan;
        $DataGuru->save();

        Session::flash('success', 'Berhasil Mengubah Data');

        return redirect('/DataGuru');
    }
}
