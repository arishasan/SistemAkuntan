<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PiutangModel extends Model
{
    use HasFactory;
    protected $table = 'tb_piutang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pesanan',
        'nominal',
        'status',
        'tanggal_bayar',
        'periode',
        'is_jurnal',
        'is_jurnal_bayar'
    ];
}
