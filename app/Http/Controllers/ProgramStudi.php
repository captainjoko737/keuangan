<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\MUangPendaftaran;
use App\Models\MBukuPedoman;
use App\Models\MMutasi;
use App\Models\MMahasiswa;
use App\Models\MProgramStudi;
use App\Models\MJenisTransaksi;
use Auth;
use View;
use App\Dashboard\Controllers;
use DB;
use Carbon\Carbon;
use PDF;

class ProgramStudi extends Controller
{
    
    public function index(request $request) {

    	$data['title'] = 'Laporan Per Program Studi';

    	$data['program_studi'] = MProgramStudi::all();

    	return view('laporan.program_studi.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['program_studi'] = MProgramStudi::all();

    	$data['title'] = 'Laporan Per Program Studi';

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	$dateFrom = Carbon::parse($request->date_from);
    	$dateTo = Carbon::parse($request->date_to);
    	
    	$mutasi = MMutasi::whereBetween('TGL_TRANS', [$dateFrom, $dateTo])
    					->join('mahasiswa', 'mahasiswa.NIM', '=', 'mutasi.NIM')
    					->where('mahasiswa.KODE_PROGSTUDI', $request['program_studi'])
    					->get();

    	$kelas = [];
    	$kelasB = [];

    	$totalKelas = 0;
    	$totalKelasB = 0;
    	foreach ($mutasi as $key => $value) {
    		
    		if ($value->KELAS == "") {
    			array_push($kelas, $value);
    			$totalKelas += $value->JUMLAH;
    		}else{
    			array_push($kelasB, $value);
    			$totalKelasB += $value->JUMLAH;
    		}

    	}

    	$resultKelas = array();

	    foreach ($kelas as $item) {
	        $key = $item['JNS_TRANS'];
	        if (!array_key_exists($key, $resultKelas)) {
	            $resultKelas[$key] = $item;
	        } else {
	            $resultKelas[$key]['JUMLAH'] = $resultKelas[$key]['JUMLAH'] + $item['JUMLAH'];
	        }
	    }

	    $kelas = [];
	    $sub = [];

	 	

	    foreach ($resultKelas as $key => $value) {
	    	array_push($sub, $value);
	    }
	    $kelas['title'] = 'Kelas';
	    $kelas['total'] = $totalKelas;
	    $kelas['result'] = $sub;

	    array_push($result, $kelas);


	    $resultKelasB = array();

	    foreach ($kelasB as $item) {
	        $key = $item['JNS_TRANS'];
	        if (!array_key_exists($key, $resultKelasB)) {
	            $resultKelasB[$key] = $item;
	        } else {
	            $resultKelasB[$key]['JUMLAH'] = $resultKelasB[$key]['JUMLAH'] + $item['JUMLAH'];
	        }
	    }

	    $kelasB = [];
	    $sub = [];

	    foreach ($resultKelasB as $key => $value) {
	    	array_push($sub, $value);
	    }
	    $kelasB['title'] = 'Kelas B';
	    $kelasB['total'] = $totalKelasB;
	    $kelasB['result'] = $sub;

	    array_push($result, $kelasB);

	    $data['total'] = $totalKelas + $totalKelasB;
		$data['result'] = $result;

		if ($request->state == 'result') {
			return view('laporan.program_studi.index', $data);
		}else{

			$nps = MProgramStudi::where('KODE_PROGSTUDI', $request->program_studi)->first();
			$data['nama_program_studi'] = $nps['NAMA_PROGSTUDI'];

			$pdf = PDF::loadView('laporan.program_studi.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('laporan.pdf');
		}

    	
    }

}
