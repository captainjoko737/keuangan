<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MJenisTransaksi extends Model
{
    protected $table = 'jns_transaksi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nomor_urut', 'jns_trans', 'periode_byr', 'semester', 
    ];

    
}
