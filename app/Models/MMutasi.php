<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMutasi extends Model
{
    protected $table = 'mutasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NIM', 'JUMLAH', 'TGL_TRANS', 'JNS_TRANS', 'NO_KWITANSI', 'SEMESTER', 'TAHUN', 'P', 'TAG',
    ];

    protected $dates = ['TGL_TRANS'];
    
}
