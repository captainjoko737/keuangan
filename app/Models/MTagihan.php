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
        'AKADEMIK',
        
    ];
}
