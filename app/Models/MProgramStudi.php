<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MProgramStudi extends Model
{
    protected $table = 'program_studi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'KODE_PROGSTUDI',  
        'NAMA_PROGSTUDI',  
        'WALI_STUDI',  
        'JENIS_PROGSTUDI', 
        'TAG',
        
    ];

    // public function mhs()
    //  {
    //       return $this->hasMany('App\Models\MMahasiswa', 'KODE_PROGSTUDI', 'KODE_PROGSTUDI')->join('mutasi', 'mutasi.NIM', '=', 'mahasiswa.NIM')->count('mutasi.JUMLAH');
    //  }

}
