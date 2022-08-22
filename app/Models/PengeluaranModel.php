<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengeluaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pengeluaran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tgl_pengeluaran',
        'keterangan',
        'nominal',
        'is_jurnal'
    ];
}
