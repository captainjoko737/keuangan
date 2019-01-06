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
use App\Models\MPengguna;
use App\Models\MTransaksi;
use Auth;
use View;
use App\Dashboard\Controllers;
use DB;
use Carbon\Carbon;
use PDF;

class Kasir extends Controller
{
    
    public function index(request $request) {

    	$data['title'] = 'Laporan Per Kasir';

    	$data['kasir'] = MPengguna::select('NAMA')->get();

    	return view('laporan.kasir.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['kasir'] = MPengguna::select('NAMA')->get();

    	$data['title'] = 'Laporan Per Kasir';

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	$dateFrom = Carbon::parse($request->date_from);
    	$dateTo = Carbon::parse($request->date_to)->addHours(23);

    	$mutasi = MTransaksi::where('transaksi.PENGGUNA', $request['nama'])
    					->join('mutasi', 'mutasi.NO_KWITANSI', '=', 'transaksi.NO_KWITANSI')
    					->join('jns_transaksi', 'jns_transaksi.jns_trans', '=', 'mutasi.JNS_TRANS')
    					->whereBetween('transaksi.TGL_TRANS', [$dateFrom, $dateTo])
    					->get();

		$arr = array();
		foreach ($mutasi as $item) {

			if ($item['periode_byr'] == 'SPP') {
				$arr['SPP'][] = $item;
			}else{
				$arr[$item['JNS_TRANS']][] = $item;
			}
		    
		}

		$sub = [];

		foreach ($arr as $key => $value) {

			$total = 0;
			foreach ($value as $keys => $values) {
				$total += $values['JUMLAH'];
			}

			$res[$key]['result'] = $value;
			$res[$key]['total'] = $total;
			$res[$key]['title'] = $key;
		}

		$sub = [];

		foreach ($res as $key => $value) {
			array_push($sub, $value);
		}

		$data['result'] = $sub;

		if ($request->state == 'result') {
			return view('laporan.kasir.index', $data);
		}else{
			$pdf = PDF::loadView('laporan.kasir.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('laporan.pdf');
		}

    	
    }

}
