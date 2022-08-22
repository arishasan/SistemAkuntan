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

class AdmPemesananController extends Controller
{
    public function __construct(){

    }

    public function index(Request $req){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_produk' => ProdukModel::select(DB::raw('tb_produk.*, tb_kategori.nama as `nama_kategori`'))->join('tb_kategori', 'tb_produk.id_kategori','=','tb_kategori.id')->get()
        ];

        if(isset($req->tgl_dari)){
            $data['data_pemesanan'] = PemesananModel::whereBetween('tanggal_pesan', [$req->tgl_dari, $req->tgl_sampai])->orderBy('id', 'DESC')->get();
            $data['tgl_dari'] = $req->tgl_dari;
            $data['tgl_sampai'] = $req->tgl_sampai;
        }else{
            $data['data_pemesanan'] = PemesananModel::whereBetween('tanggal_pesan', [date('Y-m-01'), date('Y-m-t')])->orderBy('id', 'DESC')->get();
        }

        return view('admin.pages.adm_pemesanan.index')->with($data);
    }

    public function detail($id){
        $data = [
            'data_pemesanan' => PemesananModel::where(DB::raw('md5(id)'), $id)->first(),
            'det_pemesanan' => DetPemesananModel::where(DB::raw('md5(id_pesanan)'), $id)->get()
        ];
        return view('admin.pages.adm_pemesanan.detail')->with($data);
    }

    public function edit($id){
        $data = [
            'data_pemesanan' => PemesananModel::where(DB::raw('md5(id)'), $id)->first(),
        ];
        return view('admin.pages.adm_pemesanan.edit')->with($data);
    }

    public function store(Request $req){
        
        $item_id = $req->item_id;
        $item_harga = $req->item_harga;
        $item_qty = $req->item_qty;
        $item_tot = $req->item_tot;

        if(!isset($item_id)){
            Session::flash('error', 'Tidak ada yang diproses.');
    		return redirect()->route('adm_pemesanan');
        }
        
        $baru = new PemesananModel;
        $baru->kode_pesanan = PemesananModel::generate_kode();
        $baru->nama_pemesan = $req->nama;
        $baru->total_pembayaran = str_replace(",", "", $req->tot_bayar);
        $baru->tipe_pesanan = $req->tipe_pesanan;
        $baru->tanggal_pesan = $req->tgl_pesan;
        $baru->catatan = $req->catatan;

        if($baru->save()){
            
            $uid = $baru->id;

            if($req->tipe_pesanan == 'BAYAR'){

                $masuk = new PemasukanModel;
                $masuk->id_pesanan = $uid;
                $masuk->keterangan = 'Pemesanan dengan kode pesanan : '.$baru->kode_pesanan;
                $masuk->tgl_pemasukan = date('Y-m-d');
                $masuk->nominal = str_replace(",", "", $req->tot_bayar);
                $masuk->is_jurnal = 0;
                $masuk->save();

            }else{

                $piutang = new PiutangModel;
                $piutang->id_pesanan = $uid;
                $piutang->nominal = str_replace(",", "", $req->tot_bayar);
                $piutang->status = 'BELUM BAYAR';
                $piutang->tanggal_bayar = null;
                $piutang->periode = date('Y-m-d');
                $piutang->is_jurnal = 0;
                $piutang->save();

            }
            
            if(isset($item_id)){

                foreach ($item_id as $key => $value) {
                    $det = new DetPemesananModel;
                    $det->id_pesanan = $uid;
                    $det->id_produk = $value;
                    $det->qty = $item_qty[$key];
                    $det->harga_satuan = $item_harga[$key];
                    $det->save();
                }

            }

            Session::flash('success', 'Berhasil menyimpan data pemesanan baru.');
    		return redirect()->route('adm_pemesanan');
        }else{
            Session::flash('error', 'Gagal menyimpan data pemesanan baru.');
    		return redirect()->route('adm_pemesanan');
        }

    }

    public function delete($id){

        $data = PemesananModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            DetPemesananModel::where(DB::raw('md5(id_pesanan)'), $id)->delete();
            PemasukanModel::where(DB::raw('md5(id_pesanan)'), $id)->delete();
            PiutangModel::where(DB::raw('md5(id_pesanan)'), $id)->delete();
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data pemesanan.');
            }else{
                Session::flash('error', 'Gagal menghapus data pemesanan.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data pemesanan.');
        }

    }

    public function update(Request $req){

        $get_data = PemesananModel::find($req->id);
        if(null !== $get_data){

            $get_data->nama_pemesan = $req->nama;
            $get_data->tanggal_pesan = $req->tgl_pesan;
            $get_data->catatan = $req->catatan;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data pemesanan.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data pemesanan.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data pemesanan.');
            return redirect()->route('adm_pemesanan');

        }

    }

   
}
