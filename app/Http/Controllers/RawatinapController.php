<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Dokter,Pasien,Obat, Rawatinap, Ruangan};
use RealRashid\SweetAlert\Facades\Alert;

class RawatinapController extends Controller
{
    public function index()
    {
        $data = [
            'dokter' => Dokter::get(),
            'obat' => Obat::get(),
            'ruangan' => Ruangan::get(),
            'pasien' => Pasien::get(),
            'rawatinap' => Rawatinap::with('dokter','ruangan','pasien','obat')->get() 
        ];      
        return view('rawatinap.rawatinap' ,$data);
    }

    public function store(Request $request)
    {
        $rawatinap = new Rawatinap; 
        $rawatinap->pasien_id = $request->nama;
        $rawatinap->dokter_id = $request->nama_dokter;
        $rawatinap->ruangan_id = $request->nama_ruangan;
        $rawatinap->save();
        $rawatinap->obat()->attach($request->nama_obat);
        Alert::success('Tersimpan','Data Berhasil Disimpan');
        return redirect()->route( 'rawatinap.index' ); 
    }
  
    public function edit($id)
    {
        $rawatinap = Rawatinap::findOrFail($id); 
        return view('rawatinap.edit',[
            'dokter' => Dokter::get(),
            'ruangan' => Ruangan::get(),
            'obat' => Obat::get(),
            'pasien' => Pasien::get(),
            'rawatinap' => $rawatinap]); 
    }
   
    public function update(Request $request, $id)
    {
        $rawatinap = Rawatinap::findOrFail($id); 
        $rawatinap->pasien_id = $request->nama;
        $rawatinap->dokter_id = $request->nama_dokter;
        $rawatinap->ruangan_id = $request->nama_ruangan;
        $rawatinap->update();
        $rawatinap->obat()->sync(request('nama_obat'));
        Alert::success('Terupdate','Data Berhasil Diupdate');
        return redirect()->route('rawatinap.index' ); 
    }

    public function destroy($id)
    {
        $rawatinap = Rawatinap::findOrFail($id);
        $rawatinap->delete();
        Alert::success('Terhapus','Data Berhasil Dihapus');
        return redirect()->route('rawatinap.index');
    }
}
