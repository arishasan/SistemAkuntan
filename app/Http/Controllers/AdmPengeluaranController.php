<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use App\Models\HelperModel;
use App\Models\PengeluaranModel;

class AdmPengeluaranController extends Controller
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
            $data['data_pengeluaran'] = PengeluaranModel::whereBetween(DB::raw('substr(tgl_pengeluaran,1, 10)'), [$req->tgl_dari, $req->tgl_sampai])->orderBy('tgl_pengeluaran', 'ASC')->get();
            $data['tgl_dari'] = $req->tgl_dari;
            $data['tgl_sampai'] = $req->tgl_sampai;
        }else{
            $data['data_pengeluaran'] = PengeluaranModel::whereBetween(DB::raw('substr(tgl_pengeluaran,1, 10)'), [date('Y-m-01'), date('Y-m-t')])->orderBy('tgl_pengeluaran', 'ASC')->get();
        }
        
        return view('admin.pages.adm_pengeluaran.index')->with($data);
    }

    public function edit($id){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_pengeluaran' => PengeluaranModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.adm_pengeluaran.edit')->with($data);
    }

    public function store(Request $req){

        $baru = new PengeluaranModel;
        $baru->tgl_pengeluaran = $req->tgl_pengeluaran;
        $baru->keterangan = $req->keterangan;
        $baru->nominal = str_replace(",", "", $req->nominal);
        $baru->is_jurnal = 0;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data pengeluaran baru.');
    		return redirect()->route('adm_pengeluaran');
        }else{
            Session::flash('error', 'Gagal menyimpan data pengeluaran baru.');
    		return redirect()->route('adm_pengeluaran');
        }

    }

    public function delete($id){

        $data = PengeluaranModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data pengeluaran.');
            }else{
                Session::flash('error', 'Gagal menghapus data pengeluaran.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data pengeluaran.');
        }

    }

    public function update(Request $req){

        $get_data = PengeluaranModel::find($req->id);
        if(null !== $get_data){

            $get_data->tgl_pengeluaran = $req->tgl_pengeluaran;
            $get_data->keterangan = $req->keterangan;
            $get_data->nominal = str_replace(",", "", $req->nominal);

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data pengeluaran.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data pengeluaran.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data pengeluaran.');
            return redirect()->route('adm_pengeluaran');

        }

    }

   
}
