<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AksesModel;
use DateTime;

class HelperModel extends Model
{
    use HasFactory;

    static function allowedAccess($modul){

        if($modul == 'Master'){

            $array = array(
                'Admin'
            );

            if(in_array(Auth()->user()->level, $array)){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }

    static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }

    static function convertBulanTahunIndo($string){

        try {
            $boom = explode("-", $string);
            $bb = '';

            if($boom[0] == '01'){
                $bb = 'Januari';
            }else if($boom[0] == '02'){
                $bb = 'Februari';
            }else if($boom[0] == '03'){
                $bb = 'Maret';
            }else if($boom[0] == '04'){
                $bb = 'April';
            }else if($boom[0] == '05'){
                $bb = 'Mei';
            }else if($boom[0] == '06'){
                $bb = 'Juni';
            }else if($boom[0] == '07'){
                $bb = 'Juli';
            }else if($boom[0] == '08'){
                $bb = 'Agustus';
            }else if($boom[0] == '09'){
                $bb = 'September';
            }else if($boom[0] == '10'){
                $bb = 'Oktober';
            }else if($boom[0] == '11'){
                $bb = 'November';
            }else if($boom[0] == '12'){
                $bb = 'Desember';
            }

            return $bb.' '.$boom[1];
        } catch (\Throwable $th) {
            return '-';
        }
            
    }

    static function getNamaBulan($string){

        try {
            $boom = $string;
            $bb = '';

            if($boom == '01'){
                $bb = 'Januari';
            }else if($boom == '02'){
                $bb = 'Februari';
            }else if($boom == '03'){
                $bb = 'Maret';
            }else if($boom == '04'){
                $bb = 'April';
            }else if($boom == '05'){
                $bb = 'Mei';
            }else if($boom == '06'){
                $bb = 'Juni';
            }else if($boom == '07'){
                $bb = 'Juli';
            }else if($boom == '08'){
                $bb = 'Agustus';
            }else if($boom == '09'){
                $bb = 'September';
            }else if($boom == '10'){
                $bb = 'Oktober';
            }else if($boom == '11'){
                $bb = 'November';
            }else if($boom == '12'){
                $bb = 'Desember';
            }

            return $bb;
        } catch (\Throwable $th) {
            return '-';
        }
            
    }

    static function get_sum_neraca($push_tgl){

        $temp = array();

        for ($i=1; $i <= 12; $i++) { 
            $bulan = ($i < 10 ? '0' : '').$i;
            $tahun = $push_tgl;
            $periode = $bulan.'-'.$tahun;
            
            $sum_debit = 0;
            $sum_kredit = 0;

            // SUM PEMASUKAN
            $get_pemasukan = PemasukanModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('MONTH(tgl_pemasukan)'), $bulan)->where(DB::raw('YEAR(tgl_pemasukan)'), $tahun)->first();
            $sum_debit += $get_pemasukan->nominal ?? 0;

            // SUM PENGELUARAN
            $get_pengeluaran = PengeluaranModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('MONTH(tgl_pengeluaran)'), $bulan)->where(DB::raw('YEAR(tgl_pengeluaran)'), $tahun)->first();
            $sum_kredit += $get_pengeluaran->nominal ?? 0;

            // SUM PIUTANG
            $get_piutang = PiutangModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('MONTH(periode)'), $bulan)->where(DB::raw('YEAR(periode)'), $tahun)->first();
            $sum_kredit += $get_piutang->nominal ?? 0;

            // SUM PIUTANG BAYAR
            $get_piutang_bayar = PiutangModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('MONTH(tanggal_bayar)'), $bulan)->where(DB::raw('YEAR(tanggal_bayar)'), $tahun)->first();
            $sum_debit += $get_piutang_bayar->nominal ?? 0;

            // GET KAS
            $get_kas = SaldoModel::where('periode', $periode)->orderBy('id', 'DESC')->first();
            if(null !== $get_kas){
                $sum_debit += $get_kas->nominal;
            }

            $t = array(
                'periode' => $periode,
                'debit' => $sum_debit,
                'kredit' => $sum_kredit,
            );

            array_push($temp, $t);

        }

        return $temp;

    }

    static function get_detail_neraca($bln, $thn){

        $data = array();

        $bulan = $bln;
        $tahun = $thn;
        $periode = $bulan.'-'.$tahun;
        
        // SUM PEMASUKAN
        $get_pemasukan = PemasukanModel::where(DB::raw('MONTH(tgl_pemasukan)'), $bulan)->where(DB::raw('YEAR(tgl_pemasukan)'), $tahun)->get();
        foreach($get_pemasukan as $val){
            $temp = array(
                'id' => $val->id,
                'keterangan' => $val->keterangan,
                'tgl' => $val->tgl_pemasukan,
                'nominal' => $val->nominal,
                'type' => 'DEBIT'
            );
            array_push($data, $temp);
        }

        // SUM PENGELUARAN
        $get_pengeluaran = PengeluaranModel::where(DB::raw('MONTH(tgl_pengeluaran)'), $bulan)->where(DB::raw('YEAR(tgl_pengeluaran)'), $tahun)->get();
        foreach($get_pengeluaran as $val){
            $temp = array(
                'id' => $val->id,
                'keterangan' => $val->keterangan,
                'tgl' => $val->tgl_pengeluaran,
                'nominal' => $val->nominal,
                'type' => 'KREDIT'
            );
            array_push($data, $temp);
        }

        // SUM PIUTANG
        $get_piutang = PiutangModel::where(DB::raw('MONTH(periode)'), $bulan)->where(DB::raw('YEAR(periode)'), $tahun)->get();
        foreach($get_piutang as $val){

            $getTRX = PemesananModel::find($val->id_pesanan);
            $kode = '-';
            if(null !== $getTRX){
                $kode = $getTRX->kode_pesanan;
            }

            $temp = array(
                'id' => $val->id,
                'keterangan' => 'Piutang Transaksi Dengan Kode Pemesanan : '.$kode,
                'tgl' => $val->periode,
                'nominal' => $val->nominal,
                'type' => 'KREDIT'
            );
            array_push($data, $temp);

        }

        // SUM PIUTANG BAYAR
        $get_piutang_dibayar = PiutangModel::where(DB::raw('MONTH(tanggal_bayar)'), $bulan)->where(DB::raw('YEAR(tanggal_bayar)'), $tahun)->get();
        foreach($get_piutang_dibayar as $val){

            $getTRX = PemesananModel::find($val->id_pesanan);
            $kode = '-';
            if(null !== $getTRX){
                $kode = $getTRX->kode_pesanan;
            }

            $temp = array(
                'id' => $val->id,
                'keterangan' => 'Bayar Piutang Transaksi Dengan Kode Pemesanan : '.$kode,
                'tgl' => $val->tanggal_bayar,
                'nominal' => $val->nominal,
                'type' => 'DEBIT'
            );
            array_push($data, $temp);

        }

        // GET KAS
        $get_kas = SaldoModel::where('periode', $periode)->orderBy('id', 'DESC')->first();
        if(null !== $get_kas){

            $temp = array(
                'id' => 0,
                'keterangan' => 'Modal Usaha',
                'tgl' => date('Y-m-d', strtotime($get_kas->updated_at)),
                'nominal' => $get_kas->nominal,
                'type' => 'DEBIT'
            );
            array_push($data, $temp);
            
        }
        
        // Sort the array 
        usort($data, function ($element1, $element2) {
            $datetime1 = strtotime($element1['tgl']);
            $datetime2 = strtotime($element2['tgl']);
            return $datetime1 - $datetime2;
        });

        return $data;

    }

}
