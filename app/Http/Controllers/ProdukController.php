<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use App\Models\HelperModel;
use App\Models\KategoriModel;
use App\Models\ProdukModel;

class ProdukController extends Controller
{
    public function __construct(){

    }

    public function index(){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_kategori' => KategoriModel::all(),
            'data_produk' => ProdukModel::select(DB::raw('tb_produk.*, tb_kategori.nama as `nama_kategori`'))->join('tb_kategori', 'tb_produk.id_kategori','=','tb_kategori.id')->get()
        ];
        return view('admin.pages.produk.index')->with($data);
    }

    public function detail($id){
        $data = [
            'data_produk' => ProdukModel::select(DB::raw('tb_produk.*, tb_kategori.nama as `nama_kategori`'))->join('tb_kategori', 'tb_produk.id_kategori','=','tb_kategori.id')->where(DB::raw('md5(tb_produk.id)'), $id)->first()
        ];
        return view('admin.pages.produk.detail')->with($data);
    }

    public function edit($id){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_kategori' => KategoriModel::all(),
            'data_produk' => ProdukModel::select(DB::raw('tb_produk.*, tb_kategori.nama as `nama_kategori`'))->join('tb_kategori', 'tb_produk.id_kategori','=','tb_kategori.id')->where(DB::raw('md5(tb_produk.id)'), $id)->first()
        ];
        return view('admin.pages.produk.edit')->with($data);
    }

    public function store(Request $req){
        
        $baru = new ProdukModel;
        $baru->id_kategori = $req->kategori;
        $baru->kode_produk = ProdukModel::generate_kode();
        $baru->nama = $req->nama;
        $baru->deskripsi = $req->deskripsi;
        $baru->harga = str_replace(",", "", $req->harga);
        $baru->stok = 0;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data produk baru.');
    		return redirect()->route('produk');
        }else{
            Session::flash('error', 'Gagal menyimpan data produk baru.');
    		return redirect()->route('produk');
        }

    }

    public function delete($id){

        $data = ProdukModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data produk.');
            }else{
                Session::flash('error', 'Gagal menghapus data produk.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data produk.');
        }

    }

    public function update(Request $req){

        $get_data = ProdukModel::find($req->id);
        if(null !== $get_data){

            $get_data->id_kategori = $req->kategori;
            $get_data->nama = $req->nama;
            $get_data->deskripsi = $req->deskripsi;
            $get_data->harga = str_replace(",", "", $req->harga);
            $get_data->stok = 0;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data produk.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data produk.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data produk.');
            return redirect()->route('produk');

        }

    }

   
}
