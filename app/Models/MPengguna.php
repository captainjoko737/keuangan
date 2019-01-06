<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MPengguna extends Model
{
    protected $table = 'pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'USER_ID',
        'NAMA',    
        'PASS',    
        'KEWENANGAN',  
        'LOKASI',  
        'AKTIFITAS',   
        'JML_KWITANSI',    
        'IP',  
        'TAG', 
        'KET',
    ];
    
}
