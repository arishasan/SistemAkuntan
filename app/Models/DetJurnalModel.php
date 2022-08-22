<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetJurnalModel extends Model
{
    use HasFactory;
    protected $table = 'tb_det_jurnal';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_jurnal',
        'type',
        'id_table'
    ];
}
