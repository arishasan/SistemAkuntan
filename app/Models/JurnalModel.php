<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JurnalModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_jurnal',
        'keterangan',
        'tgl_jurnal'
    ];

    static function generate_kode(){

        $bulan = date('Ym');
        $default = 'JN/'.$bulan.'/001';

        $getExistingData = JurnalModel::orderBy('created_at', 'desc');
        $temp = '';

        if($getExistingData->count() > 0){

            $last_data = $getExistingData->first();
            $temp = $last_data->kode_jurnal;

            $boom = explode("/", $temp);
            $increment = $boom[2] + 1;

            $susun = 'JN/'.$bulan.'/'.str_pad($increment, 3, '0', STR_PAD_LEFT);
            return $susun;

        }else{
            return $default;
        }

    }
}
