<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMahasiswa extends Model
{
    protected $table = 'mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NIM NAMA',    
        'KODE_JURUSAN',    
        'KODE_PROGSTUDI',  
        'KODE_PENDIDIKAN', 
        'ALAMAT', 
        'TGL_LAHIR',  
        'TEMPAT', 
        'ANGKATAN',    
        'SEMESTER',    
        'KELAS',   
        'AKADEMIK',    
        'TAG', 
        'KET',
        'STATUS',
        'POTONGAN'
    ];

    public function summary()
     {
          return $this->hasMany('App\Models\Mutasi', 'NIM', 'NIM');
     }

    public function prodi()
     {
          return $this->hasOne('App\Models\MProgramStudi', 'KODE_PROGSTUDI', 'KODE_PROGSTUDI');
     }

}
