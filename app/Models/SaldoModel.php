<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaldoModel extends Model
{
    use HasFactory;
    protected $table = 'tb_saldo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'periode',
        'nominal'
    ];
}
