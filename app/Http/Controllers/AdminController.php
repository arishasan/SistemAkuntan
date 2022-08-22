<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoModel;
use App\Models\PemesananModel;
use App\Models\ProdukModel;
use Session;

class AdminController extends Controller
{	
	public function __construct(){

	}
    
    public function index(Request $req){
        $data = array();

        if(isset($req->tahun)){

            // KAS AKTIF
            $saldo = SaldoModel::where('periode', $req->bulan.'-'.$req->tahun)->orderBy('id', 'DESC')->first();

            // Pengeluaran & pemasukan & piutang
            $pengeluaran = DashboardModel::get_sum_pemasukan_pengeluaran($req->tahun, $req->bulan, 2);
            $pemasukan = DashboardModel::get_sum_pemasukan_pengeluaran($req->tahun, $req->bulan, 1);
            $piutang = DashboardModel::get_sum_pemasukan_pengeluaran($req->tahun, $req->bulan, 3);
            
            // CHART
            $chart = DashboardModel::getChartPendapatanPengeluaran($req->tahun, $req->bulan);
            $data = array(
                'kas_aktif' => $saldo->nominal ?? 0,
                'pengeluaran' => $pengeluaran,
                'pemasukan' => $pemasukan,
                'piutang' => $piutang,
                'pemesanan' => PemesananModel::where(DB::raw('MONTH(tanggal_pesan)'), $req->bulan)->where(DB::raw('YEAR(tanggal_pesan)'), $req->tahun)->orderBy('id', 'DESC')->limit(10)->get(),
                'produk' => ProdukModel::where(DB::raw('MONTH(created_at)'), $req->bulan)->where(DB::raw('YEAR(created_at)'), $req->tahun)->orderBy('id', 'DESC')->limit(5)->get(),
                'chart' => json_encode($chart),
                'bulan' => $req->bulan,
                'tahun' => $req->tahun,
            );

        }else{

            // KAS AKTIF
            $saldo = SaldoModel::where('periode', date('m-Y'))->orderBy('id', 'DESC')->first();

            // Pengeluaran & pemasukan & piutang
            $pengeluaran = DashboardModel::get_sum_pemasukan_pengeluaran(date('Y'), date('m'), 2);
            $pemasukan = DashboardModel::get_sum_pemasukan_pengeluaran(date('Y'), date('m'), 1);
            $piutang = DashboardModel::get_sum_pemasukan_pengeluaran(date('Y'), date('m'), 3);
            
            // CHART
            $chart = DashboardModel::getChartPendapatanPengeluaran(date('Y'), date('m'));
            $data = array(
                'kas_aktif' => $saldo->nominal ?? 0,
                'pengeluaran' => $pengeluaran,
                'pemasukan' => $pemasukan,
                'piutang' => $piutang,
                'pemesanan' => PemesananModel::where(DB::raw('MONTH(tanggal_pesan)'), date('m'))->where(DB::raw('YEAR(tanggal_pesan)'), date('Y'))->orderBy('id', 'DESC')->limit(10)->get(),
                'produk' => ProdukModel::where(DB::raw('MONTH(created_at)'), date('m'))->where(DB::raw('YEAR(created_at)'), date('Y'))->orderBy('id', 'DESC')->limit(5)->get(),
                'chart' => json_encode($chart)
            );
        }

    	return view('index-admin')->with($data);
    }

    public function update_saldo_index(){

        $data = array(
            'saldo_bulan_ini' => SaldoModel::where('periode', date('m-Y'))->orderBy('id', 'DESC')->first(),
            'data_saldo' => SaldoModel::orderBy('periode', 'DESC')->get(),
        );
    	return view('admin.system.saldo.index')->with($data);

    }

    public function update_saldo_execute(Request $req){
        
        $periode = $req->bulan.'-'.$req->tahun;
        $checkDB = SaldoModel::where('periode', $periode)->orderBy('id', 'DESC')->first();

        if(null !== $checkDB){
            
            $checkDB->nominal = str_replace(",", "", $req->nominal_saldo);
            
            if($checkDB->save()){
                Session::flash('success', 'Berhasil mengupdate data saldo/modal.');
    		    return redirect()->route('update_saldo');
            }else{
                Session::flash('error', 'Gagal mengupdate data saldo/modal.');
    		    return redirect()->route('update_saldo');
            }
            
        }else{

            $new = new SaldoModel;
            $new->periode = $periode;
            $new->nominal = str_replace(",", "", $req->nominal_saldo);
            
            if($new->save()){
                Session::flash('success', 'Berhasil mengupdate data saldo/modal.');
    		    return redirect()->route('update_saldo');
            }else{
                Session::flash('error', 'Gagal mengupdate data saldo/modal.');
    		    return redirect()->route('update_saldo');
            }

        }

    }

}
