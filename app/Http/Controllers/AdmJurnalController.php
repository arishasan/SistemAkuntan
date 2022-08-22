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
use App\Models\PengeluaranModel;
use App\Models\JurnalModel;
use App\Models\DetJurnalModel;

class AdmJurnalController extends Controller
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
            $data['data_jurnal'] = JurnalModel::whereBetween(DB::raw('tgl_jurnal'), [$req->tgl_dari, $req->tgl_sampai])->orderBy('tgl_jurnal', 'DESC')->get();
            $data['tgl_dari'] = $req->tgl_dari;
            $data['tgl_sampai'] = $req->tgl_sampai;
        }else{
            $data['data_jurnal'] = JurnalModel::whereBetween(DB::raw('tgl_jurnal'), [date('Y-m-01'), date('Y-m-t')])->orderBy('tgl_jurnal', 'DESC')->get();
        }

        return view('admin.pages.adm_jurnal.index')->with($data);
    }

    public function detail($id){
        $data = [
            'data_jurnal' => JurnalModel::where(DB::raw('md5(id)'), $id)->first(),
            'det_jurnal' => DetJurnalModel::where(DB::raw('md5(id_jurnal)'), $id)->get(),
        ];
        return view('admin.pages.adm_jurnal.detail')->with($data);
    }

    public function get_trx_list($tgl){

        $data = array();
        $get_pemasukan = PemasukanModel::where('is_jurnal', 0)->where('tgl_pemasukan', $tgl)->get();
        foreach($get_pemasukan as $val){
            $temp = array(
                'id' => $val->id,
                'keterangan' => $val->keterangan,
                'tgl' => date('d M Y', strtotime($val->tgl_pemasukan)),
                'nominal' => $val->nominal,
                'type' => 'PEMASUKAN'
            );
            array_push($data, $temp);
        }

        $get_pengeluaran = PengeluaranModel::where('is_jurnal', 0)->where('tgl_pengeluaran', $tgl)->get();
        foreach($get_pengeluaran as $val){
            $temp = array(
                'id' => $val->id,
                'keterangan' => $val->keterangan,
                'tgl' => date('d M Y', strtotime($val->tgl_pengeluaran)),
                'nominal' => $val->nominal,
                'type' => 'PENGELUARAN'
            );
            array_push($data, $temp);
        }

        $get_piutang = PiutangModel::where('is_jurnal', 0)->where('periode', $tgl)->get();
        foreach($get_piutang as $val){

            $getTRX = PemesananModel::find($val->id_pesanan);
            $kode = '-';
            if(null !== $getTRX){
                $kode = $getTRX->kode_pesanan;
            }

            $temp = array(
                'id' => $val->id,
                'keterangan' => 'Piutang Transaksi Dengan Kode Pemesanan : '.$kode,
                'tgl' => date('d M Y', strtotime($val->periode)),
                'nominal' => $val->nominal,
                'type' => 'PIUTANG'
            );
            array_push($data, $temp);

        }
        
        $get_piutang_dibayar = PiutangModel::where('is_jurnal_bayar', 0)->where('tanggal_bayar', $tgl)->get();
        foreach($get_piutang_dibayar as $val){

            $getTRX = PemesananModel::find($val->id_pesanan);
            $kode = '-';
            if(null !== $getTRX){
                $kode = $getTRX->kode_pesanan;
            }

            $temp = array(
                'id' => $val->id,
                'keterangan' => 'Bayar Piutang Transaksi Dengan Kode Pemesanan : '.$kode,
                'tgl' => date('d M Y', strtotime($val->tanggal_bayar)),
                'nominal' => $val->nominal,
                'type' => 'PIUTANG DIBAYAR'
            );
            array_push($data, $temp);

        }

        // echo "<pre>";
        // print_r($data);

        // foreach($data as $val){
        //     echo $val['id'];
        // }

        echo json_encode($data);

    }

    public function store(Request $req){

        $idnya = $req->id;
        $typenya = $req->type;

        if(isset($idnya)){}else{
            Session::flash('error', 'Tidak ada yang diproses.');
    		return redirect()->route('adm_jurnal');
        }

        $baru = new JurnalModel;
        $baru->kode_jurnal = JurnalModel::generate_kode();
        $baru->tgl_jurnal = $req->tgl_jurnal;
        $baru->keterangan = $req->keterangan;

        if($baru->save()){

            foreach($idnya as $key => $val){
            
                $det = new DetJurnalModel;
                $det->id_jurnal = $baru->id;
                $det->type = $typenya[$key];
                $det->id_table = $val;
                $det->save();

                if($typenya[$key] == 'PEMASUKAN'){

                    $get_pemasukan = PemasukanModel::where('id', $val)->first();
                    if(null !== $get_pemasukan){
                        $get_pemasukan->is_jurnal = 1;
                        $get_pemasukan->save();
                    }

                }else if($typenya[$key] == 'PENGELUARAN'){

                    $get_pengeluaran = PengeluaranModel::where('id', $val)->first();
                    if(null !== $get_pengeluaran){
                        $get_pengeluaran->is_jurnal = 1;
                        $get_pengeluaran->save();
                    }

                }else if($typenya[$key] == 'PIUTANG'){

                    $getHutang = PiutangModel::where('id', $val)->first();
                    if(null !== $getHutang){
                        $getHutang->is_jurnal = 1;
                        $getHutang->save();
                    }

                }else if($typenya[$key] == 'PIUTANG DIBAYAR'){

                    $get_pemasukan = PiutangModel::where('id', $val)->first();
                    if(null !== $get_pemasukan){
                        $get_pemasukan->is_jurnal_bayar = 1;
                        $get_pemasukan->save();
                    }

                }else{

                }
    
            }

            Session::flash('success', 'Berhasil menyimpan data jurnal baru.');
    		return redirect()->route('adm_jurnal');
        }else{
            Session::flash('error', 'Gagal menyimpan data jurnal baru.');
    		return redirect()->route('adm_jurnal');
        }

    }

    public function delete($id){

        $data = JurnalModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){

            $uid = $data->id;

            $get_det = DetJurnalModel::where('id_jurnal', $uid)->get();
            foreach ($get_det as $key => $value) {
                
                if($value->type == 'PEMASUKAN'){

                    $get_pemasukan = PemasukanModel::where('id', $value->id_table)->first();
                    if(null !== $get_pemasukan){
                        $get_pemasukan->is_jurnal = 0;
                        $get_pemasukan->save();
                    }

                }else if($value->type == 'PENGELUARAN'){

                    $get_pengeluaran = PengeluaranModel::where('id', $value->id_table)->first();
                    if(null !== $get_pengeluaran){
                        $get_pengeluaran->is_jurnal = 0;
                        $get_pengeluaran->save();
                    }

                }else if($value->type == 'PIUTANG'){

                    $getHutang = PiutangModel::where('id', $value->id_table)->first();
                    if(null !== $getHutang){
                        $getHutang->is_jurnal = 0;
                        $getHutang->save();
                    }

                }else if($value->type == 'PIUTANG DIBAYAR'){

                    $get_pemasukan = PiutangModel::where('id', $value->id_table)->first();
                    if(null !== $get_pemasukan){
                        $get_pemasukan->is_jurnal_bayar = 0;
                        $get_pemasukan->save();
                    }

                }else{

                }

            }

            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data jurnal.');
            }else{
                Session::flash('error', 'Gagal menghapus data jurnal.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data jurnal.');
        }

    }
   
}
