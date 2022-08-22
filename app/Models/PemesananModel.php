<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PemesananModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pesanan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pesanan',
        'nama_pemesan',
        'total_pembayaran',
        'tipe_pesanan',
        'status_pesanan',
        'tanggal_pesan',
        'catatan'
    ];

    static function generate_kode(){

        $bulan = date('Ym');
        $default = 'TRX/'.$bulan.'/001';

        $getExistingData = PemesananModel::orderBy('created_at', 'desc');
        $temp = '';

        if($getExistingData->count() > 0){

            $last_data = $getExistingData->first();
            $temp = $last_data->kode_pesanan;

            $boom = explode("/", $temp);
            $increment = $boom[2] + 1;

            $susun = 'TRX/'.$bulan.'/'.str_pad($increment, 3, '0', STR_PAD_LEFT);
            return $susun;

        }else{
            return $default;
        }

    }
}
