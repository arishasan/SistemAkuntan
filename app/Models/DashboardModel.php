<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;

class DashboardModel extends Model
{
    use HasFactory;

    static function get_sum_pemasukan_pengeluaran($tahun, $bulan, $type){

        $sum = 0;

        $bulan = $bulan;
        $tahun = $tahun;
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
        // $get_kas = SaldoModel::where('periode', $periode)->orderBy('id', 'DESC')->first();
        // if(null !== $get_kas){
        //     $sum_debit += $get_kas->nominal;
        // }

        if($type == 1){
            return $sum_debit;
        }else if($type == 3){
            return $get_piutang->nominal ?? 0;
        }else{
            return $sum_kredit;
        }

    }

    static function getChartPendapatanPengeluaran($tahun, $bulan){

        $begin = date('Y-m-01', strtotime($tahun.'-'.$bulan));
        $end = date('Y-m-t', strtotime($tahun.'-'.$bulan));

        $begin = new DateTime( $begin );
        $end = new DateTime( $end );

        $temporary = array();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            
            $tgl = $i->format("Y-m-d");
            $hari = $i->format("d");
            $wei = $i->format("m-Y");

            $sum_debit = 0;
            $sum_kredit = 0;

            // SUM PEMASUKAN
            $get_pemasukan = PemasukanModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('SUBSTR(tgl_pemasukan, 1, 10)'), $tgl)->first();
            $sum_debit += $get_pemasukan->nominal ?? 0;

            // SUM PENGELUARAN
            $get_pengeluaran = PengeluaranModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('SUBSTR(tgl_pengeluaran, 1, 10)'), $tgl)->first();
            $sum_kredit += $get_pengeluaran->nominal ?? 0;

            // SUM PIUTANG
            $get_piutang = PiutangModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('SUBSTR(periode, 1, 10)'), $tgl)->first();
            $sum_kredit += $get_piutang->nominal ?? 0;

            // SUM PIUTANG BAYAR
            $get_piutang_bayar = PiutangModel::select(DB::raw('SUM(nominal) as `nominal`'))->where(DB::raw('SUBSTR(tanggal_bayar, 1, 10)'), $tgl)->first();
            $sum_debit += $get_piutang_bayar->nominal ?? 0;

            // GET KAS
            // $get_kas = SaldoModel::where('periode', $wei)->where(DB::raw('SUBSTR(updated_at, 1, 10)'), $tgl)->orderBy('id', 'DESC')->first();
            // if(null !== $get_kas){
            //     $sum_debit += $get_kas->nominal;
            // }

            
            $push = array(
                'label' => $hari,
                'nominal_pemasukan' => $sum_debit,
                'nominal_pengeluaran' => $sum_kredit
            );

            array_push($temporary, $push);
            
        }

        // echo "<pre>";
        // print_r($temporary);

        return $temporary;

    }

}
