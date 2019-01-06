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

class JenisTransaksi extends Controller
{
    
    public function index(request $request) {

    	$data['title'] = 'Laporan Per Jenis Transaksi';

    	$data['jenis_transaksi'] = MJenisTransaksi::all();

    	return view('laporan.jenis_transaksi.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['title'] = 'Laporan Per Jenis Transaksi';

    	$data['jenis_transaksi'] = MJenisTransaksi::all();

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	$dateFrom = Carbon::parse($request->date_from);
    	$dateTo = Carbon::parse($request->date_to)->addHours(23);

    	$mutasi = MMutasi::where('mutasi.JNS_TRANS', 'like', '%' . $request->jenis_transaksi . '%')
    					->join('mahasiswa', 'mahasiswa.NIM', '=', 'mutasi.NIM')
    					->whereBetween('mutasi.TGL_TRANS', [$dateFrom, $dateTo])
    					->get();

		$arr = array();
		foreach ($mutasi as $item) {
		    $arr[$item['KODE_PROGSTUDI']][] = $item;
		}

		$sub = [];

		foreach ($arr as $key => $value) {
			$title = MProgramStudi::where('KODE_PROGSTUDI', $key)->first();

		    $total = 0;
		    foreach ($value as $keys => $values) {
		    	$total += $values['JUMLAH'];
		    }

			$res['result'] = $value;
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
// return $data;
		if ($request->state == 'result') {
			return view('laporan.jenis_transaksi.index', $data);
		}else{
			$pdf = PDF::loadView('laporan.jenis_transaksi.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('laporan.pdf');
		}

    	
    }

}
