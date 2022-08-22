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
use App\Models\SaldoModel;

class AdmNeracaController extends Controller
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

        if(isset($req->tahun)){
            $data['data_neraca'] = json_encode(HelperModel::get_sum_neraca($req->tahun));
            $data['tahun'] = $req->tahun;
        }else{
            $data['data_neraca'] = json_encode(HelperModel::get_sum_neraca(date('Y')));
        }

        return view('admin.pages.adm_neraca.index')->with($data);
    }

    public function get_data($bln, $thn){

        $data['list_detail'] = HelperModel::get_detail_neraca($bln, $thn);
        return view('admin.pages.adm_neraca.detail')->with($data);

    }
   
}
