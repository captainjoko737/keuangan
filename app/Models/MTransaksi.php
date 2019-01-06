<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTransaksi extends Model
{
    protected $table = 'transaksi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NO_KWITANSI',     
        'NIM',     
        'TGL_TRANS',   
        'PENGGUNA',    
        'AKADEMIK',    
        'SEMESTER',    
        'KET',     
        'TAG', 
    ];
    
}
