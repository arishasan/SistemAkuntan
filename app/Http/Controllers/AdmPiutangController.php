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
use App\Models\PemesananModel;
use App\Models\DetPemesananModel;
use App\Models\PemasukanModel;
use App\Models\PiutangModel;

class AdmPiutangController extends Controller
{
    public function __construct(){

    }

    public function index(Request $req){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
        ];

        if(isset($req->tgl_dari)){
            $data['data_piutang'] = PiutangModel::select(DB::raw('tb_piutang.*, tb_pesanan.kode_pesanan, tb_pesanan.nama_pemesan'))->join('tb_pesanan', 'tb_piutang.id_pesanan', 'tb_pesanan.id')->whereBetween(DB::raw('substr(tb_piutang.created_at,1, 10)'), [$req->tgl_dari, $req->tgl_sampai])->orderBy('tb_piutang.created_at', 'ASC')->get();
            $data['tgl_dari'] = $req->tgl_dari;
            $data['tgl_sampai'] = $req->tgl_sampai;
        }else{
            $data['data_piutang'] = PiutangModel::select(DB::raw('tb_piutang.*, tb_pesanan.kode_pesanan, tb_pesanan.nama_pemesan'))->join('tb_pesanan', 'tb_piutang.id_pesanan', 'tb_pesanan.id')->whereBetween(DB::raw('substr(tb_piutang.created_at,1, 10)'), [date('Y-m-01'), date('Y-m-t')])->orderBy('tb_piutang.created_at', 'ASC')->get();
        }

        return view('admin.pages.adm_piutang.index')->with($data);
    }

    public function bayar(Request $req){

        // print_r($req->all());
        $getHutang = PiutangModel::find($req->id);
        if(null !== $getHutang){

            $getHutang->status = 'SUDAH BAYAR';
            $getHutang->tanggal_bayar = $req->tglBayar;
            $getHutang->save();

            $getPemesanan = PemesananModel::find($req->pesanan);
            if(null !== $getPemesanan){
                $getPemesanan->tipe_pesanan = 'DIBAYAR';
                $getPemesanan->save();
            }

            Session::flash('success', 'Berhasil memperoses data.');

        }else{
            Session::flash('error', 'Gagal memperoses data.');
        }

    }

    public function delete($id){

        $data = PiutangModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data hutang.');
            }else{
                Session::flash('error', 'Gagal menghapus data hutang.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data hutang.');
        }

    }
   
}
