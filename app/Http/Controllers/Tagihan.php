<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\MUangPendaftaran;
use App\Models\MBukuPedoman;
use App\Models\MMutasi;
use App\Models\MMahasiswa;
use App\Models\MProgramStudi;
use App\Models\MTagihan;
use Auth;
use View;
use App\Dashboard\Controllers;
use DB;
use Carbon\Carbon;
use PDF;

class Tagihan extends Controller
{
    
    public function index() {
    	
    	$data['result'] = MTagihan::all();

    	$data['title'] = 'Tagihan';

    	return view('tagihan.index', $data);

    }

    public function create() {

    	$data['title'] = 'Tambah Tagihan';

    	$data['angkatan'] = MMahasiswa::distinct('ANGKATAN')->select('ANGKATAN')->where('ANGKATAN', '>=', 2000)->orderBy('ANGKATAN', 'DESC')->get();
    	$data['akademik'] = MMahasiswa::distinct('AKADEMIK')->select('AKADEMIK')->orderBy('AKADEMIK', 'DESC')->get();
    	$data['semester'] = MMahasiswa::distinct('SEMESTER')->select('SEMESTER')->orderBy('SEMESTER', 'ASC')->get();

    	return view('tagihan.add', $data);

    }

    public function store() {

    	$tagihan = MTagihan::where('ANGKATAN',request()->angkatan)
    					->where('SEMESTER',request()->semester)
    					->where('AKADEMIK',request()->akademik)
    					->first();

    	if (!$tagihan) {
    		$save = MTagihan::updateOrCreate([
	    		'ANGKATAN' 	=> request()->angkatan, 
	    		'SEMESTER' 	=> request()->semester,
	    		'JUMLAH' 	=> request()->jumlah, 
	    		'AKADEMIK' 	=> request()->akademik
	    	]);

	    	session()->flash('status', 'Tagihan berhasil terdaftar!');
    	}else{
    		session()->flash('error', 'Maaf, data tagihan sudah terdaftar');
    	}

    	return redirect()->route('tagihan');
    	
    }

    public function edit() {

    	$data['title'] = 'Edit Tagihan';

    	$data['angkatan'] = MMahasiswa::distinct('ANGKATAN')->select('ANGKATAN')->where('ANGKATAN', '>=', 2000)->orderBy('ANGKATAN', 'DESC')->get();
    	$data['akademik'] = MMahasiswa::distinct('AKADEMIK')->select('AKADEMIK')->orderBy('AKADEMIK', 'DESC')->get();
    	$data['semester'] = MMahasiswa::distinct('SEMESTER')->select('SEMESTER')->orderBy('SEMESTER', 'ASC')->get();

    	$data['result'] = MTagihan::where('id', request()->id)->first();

    	return view('tagihan.edit', $data);
    	
    	return request()->all();
    }

    public function save() {

    	$tagihan = MTagihan::where('ANGKATAN',request()->angkatan)
    					->where('SEMESTER',request()->semester)
    					->where('AKADEMIK',request()->akademik)
    					->first();

    	if ($tagihan) {
    		if ($tagihan->id == request()->id) {

	    		$save = MTagihan::where('id', request()->id)
			    		->update([
				    		'ANGKATAN' 	=> request()->angkatan, 
				    		'SEMESTER' 	=> request()->semester,
				    		'JUMLAH' 	=> request()->jumlah, 
				    		'AKADEMIK' 	=> request()->akademik
				    	]);

		    	session()->flash('status', 'Tagihan berhasil diperbaharui!');
	    	}else{
	    		session()->flash('error', 'Maaf, data tagihan sudah terdaftar');
	    	}
    	}else{
    		$save = MTagihan::where('id', request()->id)
			    		->update([
				    		'ANGKATAN' 	=> request()->angkatan, 
				    		'SEMESTER' 	=> request()->semester,
				    		'JUMLAH' 	=> request()->jumlah, 
				    		'AKADEMIK' 	=> request()->akademik
				    	]);

		    session()->flash('status', 'Tagihan berhasil diperbaharui!');
    	}

    	return redirect()->route('tagihan');

    }

    public function drop(request $request) {

        $result = MTagihan::where('id', $request->id)->first();
        $result->delete();

        session()->flash('status', 'Tagihan berhasil dihapus!');
        return response()->json(['success'=>"", 'tr'=>'tr_'.$request->id]);
  
    }

}


























