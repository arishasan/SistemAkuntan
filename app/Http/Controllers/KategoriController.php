<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use App\Models\HelperModel;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function __construct(){

    }

    public function index(){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_kategori' => KategoriModel::all()
        ];
        return view('admin.pages.kategori.index')->with($data);
    }

    public function edit($id){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_kategori' => KategoriModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.kategori.edit')->with($data);
    }

    public function store(Request $req){

        $baru = new KategoriModel;
        $baru->nama = $req->nama_kategori;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data kategori baru.');
    		return redirect()->route('kategori');
        }else{
            Session::flash('error', 'Gagal menyimpan data kategori baru.');
    		return redirect()->route('kategori');
        }

    }

    public function delete($id){

        $data = KategoriModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data kategori.');
            }else{
                Session::flash('error', 'Gagal menghapus data kategori.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data kategori.');
        }

    }

    public function update(Request $req){

        $get_data = KategoriModel::find($req->id);
        if(null !== $get_data){

            $get_data->nama = $req->nama_kategori;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data kategori.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data kategori.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data kategori.');
            return redirect()->route('kategori');

        }

    }

   
}
