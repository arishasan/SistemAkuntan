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

class AdmPemasukanController extends Controller
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
            $data['data_pemasukan'] = PemasukanModel::select(DB::raw('tb_pemasukan.*, tb_pesanan.kode_pesanan, tb_pesanan.nama_pemesan'))->leftJoin('tb_pesanan', 'tb_pemasukan.id_pesanan', 'tb_pesanan.id')->whereBetween(DB::raw('substr(tb_pemasukan.created_at,1, 10)'), [$req->tgl_dari, $req->tgl_sampai])->orderBy('tb_pemasukan.tgl_pemasukan', 'ASC')->get();
            $data['tgl_dari'] = $req->tgl_dari;
            $data['tgl_sampai'] = $req->tgl_sampai;
        }else{
            $data['data_pemasukan'] = PemasukanModel::select(DB::raw('tb_pemasukan.*, tb_pesanan.kode_pesanan, tb_pesanan.nama_pemesan'))->leftJoin('tb_pesanan', 'tb_pemasukan.id_pesanan', 'tb_pesanan.id')->whereBetween(DB::raw('substr(tb_pemasukan.created_at,1, 10)'), [date('Y-m-01'), date('Y-m-t')])->orderBy('tb_pemasukan.tgl_pemasukan', 'ASC')->get();
        }

        return view('admin.pages.adm_pemasukan.index')->with($data);
    }

    public function edit($id){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_pemasukan' => PemasukanModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.adm_pemasukan.edit')->with($data);
    }

    public function update(Request $req){

        $get_data = PemasukanModel::find($req->id);
        if(null !== $get_data){

            $get_data->tgl_pemasukan = $req->tgl_pemasukan;
            $get_data->keterangan = $req->keterangan;
            $get_data->nominal = str_replace(",", "", $req->nominal);

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data pemasukan.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data pemasukan.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data pemasukan.');
            return redirect()->route('adm_pemasukan');

        }

    }

    public function store(Request $req){

        $baru = new PemasukanModel;
        $baru->tgl_pemasukan = $req->tgl_pemasukan;
        $baru->keterangan = $req->keterangan;
        $baru->nominal = str_replace(",", "", $req->nominal);
        $baru->id_pesanan = 0;
        $baru->is_jurnal = 0;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data pemasukan baru.');
    		return redirect()->route('adm_pemasukan');
        }else{
            Session::flash('error', 'Gagal menyimpan data pemasukan baru.');
    		return redirect()->route('adm_pemasukan');
        }

    }

    public function delete($id){

        $data = PemasukanModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data pemasukan.');
            }else{
                Session::flash('error', 'Gagal menghapus data pemasukan.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data pemasukan.');
        }

    }
   
}
