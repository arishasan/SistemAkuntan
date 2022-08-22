<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetPemesananModel extends Model
{
    use HasFactory;
    protected $table = 'tb_det_pesanan';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'qty',
        'harga_satuan'
    ];
}
