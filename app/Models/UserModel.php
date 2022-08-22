<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'tb_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password',
        'nama',
        'level'
    ];
}
