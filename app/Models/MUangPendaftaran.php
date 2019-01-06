<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MUangPendaftaran extends Model
{
    protected $table = 'uang_pendaftaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NIM', 'JUMLAH', 'TGL_TRANS', 'NO_KWITANSI', 'TAG',
    ];

    protected $dates = ['TGL_TRANS'];
}
