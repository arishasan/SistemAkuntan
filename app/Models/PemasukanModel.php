<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PemasukanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pemasukan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tgl_pemasukan',
        'keterangan',
        'id_pesanan',
        'nominal',
        'is_jurnal'
    ];
}
