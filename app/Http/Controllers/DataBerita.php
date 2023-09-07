<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\berita;
class beritaController extends Controller
{
    //
    public function beritaGet()
    {
        $beritas = berita::all();
        return view('home.berita.index', compact('beritas'));
    }

    public function beritaCreate()
    {
        return view('home.berita.create');
    }

    public function beritaPost(Request $request)
{
        $id = $request->get('id');
        if($id){
            $berita = berita::find($id);
        }else{
            $berita = new berita;
        }
        if($request->gambar){
          if($request->hasFile('gambar')){
            $foto = $request->file('gambar');
            $filename = time() . '.' . $foto->getClientOriginalExtension();
            $destinationPath = 'image/';              
             $foto->move($destinationPath, $filename);
            }
            $berita->gambar = $filename;
        }

        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        $berita->save();
        return redirect()->route('home.berita.index')->with(['success' => 'Data Berhasil Di Simpan']);
    }

        public function beritaEdit($id)
        {
            $berita = berita::findOrFail($id);
            return view('home.berita.edit', compact('berita'));
        }


    public function beritaDel($id)
    {
        $berita = berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('home.berita.index')->with('success', 'Data berita berhasil dihapus.');
    }
}