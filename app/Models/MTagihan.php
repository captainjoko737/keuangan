<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTagihan extends Model
{
    protected $table = 'tagihan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'ANGKATAN',  
        'SEMESTER',  
        'JUMLAH',  
        'KODE_PROGSTUDI',
        'AKADEMIK',
        
    ];

    public function prodi()
    {
        return $this->hasOne('App\Models\MProgramStudi', 'KODE_PROGSTUDI', 'KODE_PROGSTUDI');
    }
}
