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

class Tahun extends Controller
{
    
    public function index(request $request) {

    	$data['title'] = 'Laporan Per Tahun';

    	$data['tahun'] = MMahasiswa::select('AKADEMIK')->distinct('AKADEMIK')->get();

    	return view('laporan.tahun.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['program_studi'] = MProgramStudi::all();
    	$data['tahun'] = MMahasiswa::select('AKADEMIK')->distinct('AKADEMIK')->get();

    	$data['title'] = 'Laporan Per Tahun';

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	$dateFrom = Carbon::parse($request->date_from);
    	$dateTo = Carbon::parse($request->date_to)->addHours(23);

    	$mutasi = MMahasiswa::where('mahasiswa.AKADEMIK', $request['tahun'])
    					->join('mutasi', 'mutasi.NIM', '=', 'mahasiswa.NIM')
    					->whereBetween('TGL_TRANS', [$dateFrom, $dateTo])
    					->get();

		$arr = array();
		foreach ($mutasi as $item) {
		    $arr[$item['KODE_PROGSTUDI']][] = $item;
		}

		$sub = [];

		foreach ($arr as $key => $value) {
			$title = MProgramStudi::where('KODE_PROGSTUDI', $key)->first();

			$groups = array();
		    foreach ($value as $item) {
		        $key = $item['JNS_TRANS'];
		        if (!array_key_exists($key, $groups)) {
		            $groups[$key] = $item;
		        } else {
		            $groups[$key]['JUMLAH'] = $groups[$key]['JUMLAH'] + $item['JUMLAH'];
		        }
		    }

		    $array = [];
		    $total = 0;
		    foreach ($groups as $keys => $values) {
		    	$total += $values['JUMLAH'];
		    	array_push($array, $values);
		    }

			$res['result'] = $array;
			$res['total']  = $total;
			$res['title']  = $title['NAMA_PROGSTUDI'];

			array_push($sub, $res);
			
		}

		$total = 0;
		foreach ($sub as $key => $value) {
			$total += $value['total'];
		}

		$data['result'] = $sub;
		$data['total'] = $total;

		if ($request->state == 'result') {
			return view('laporan.tahun.index', $data);
		}else{
			$pdf = PDF::loadView('laporan.tahun.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('laporan.pdf');
		}

    	
    }

}
