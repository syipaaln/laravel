<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa as ModelsDataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataSiswa extends Controller
{
    function index()
    {
        $data = ModelsDataSiswa::all();
        return view('data_siswa.index', ['data' => $data]);
    }
    function tambah()
    {
        return view('data_siswa.tambah');
    }
    function edit($id)
    {
        $data = ModelsDataSiswa::find($id);

        return view('data_siswa.edit', ['data' => $data]);
    }
    function hapus(Request $request)
    {
        ModelsDataSiswa::where('id', $request->id)->delete();

        Session::flash('success', 'Berhasil Hapus Data');

        return redirect('/DataSiswa');
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

        ModelsDataSiswa::insert([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');

        return redirect('/DataSiswa')->with('success', 'Berhasil Menambahkan Data');
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

        $DataSiswa = ModelsDataSiswa::find($request->id);

        $DataSiswa->name = $request->name;
        $DataSiswa->email = $request->email;
        $DataSiswa->nim = $request->nim;
        $DataSiswa->angkatan = $request->angkatan;
        $DataSiswa->jurusan = $request->jurusan;
        $DataSiswa->save();

        Session::flash('success', 'Berhasil Mengubah Data');

        return redirect('/DataSiswa');
    }
}
