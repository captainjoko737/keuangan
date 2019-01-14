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
use App\Models\MTagihan;
use Auth;
use View;
use App\Dashboard\Controllers;
use DB;
use Carbon\Carbon;
use PDF;

class Rekapitulasi extends Controller
{
    
    public function index(request $request) {

    	$data['title'] = 'Laporan Rekapitulasi';

    	// $data['jenis_transaksi'] = MJenisTransaksi::all();

    	return view('laporan.rekapitulasi.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['title'] = 'Laporan Rekapitulasi';

    	$data['jenis_transaksi'] = MJenisTransaksi::all();

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	$dateFrom = Carbon::parse($request->date_from);
    	$dateTo = Carbon::parse($request->date_to)->addHours(23);

        $spp        = [];
        $bimbingan  = [];
        $variable   = [];
        $sidang     = [];
        $bulan      = [];

        $totalSpp        = 0;
        $totalBimbingan  = 0;
        $totalVariable   = 0;
        $totalSidang     = 0;

        $diff_in_months = $dateFrom->diffInMonths($dateTo);

        for ($i=0; $i <= $diff_in_months; $i++) { 
            
            $date = $dateFrom;
            
            $sppRes = MMutasi::join('jns_transaksi', 'jns_transaksi.jns_trans', '=', 'mutasi.JNS_TRANS')
                    ->whereMonth('mutasi.TGL_TRANS', $date->format('m'))
                    ->whereYear('mutasi.TGL_TRANS', $date->format('Y'))
                    ->where('jns_transaksi.periode_byr', 'SPP')
                    ->sum('mutasi.JUMLAH');

            $bimbinganRes = MMutasi::whereMonth('TGL_TRANS', $date->format('m'))
                    ->whereYear('TGL_TRANS', $date->format('Y'))
                    ->where('JNS_TRANS', 'like', '%Bimbingan%')
                    ->sum('JUMLAH');

            $variableRes = MMutasi::whereMonth('TGL_TRANS', $date->format('m'))
                    ->whereYear('TGL_TRANS', $date->format('Y'))
                    ->where('JNS_TRANS', 'like', 'Uang Variabel')
                    ->sum('JUMLAH');

            $sidangRes = MMutasi::whereMonth('TGL_TRANS', $date->format('m'))
                    ->whereYear('TGL_TRANS', $date->format('Y'))
                    ->where('JNS_TRANS', 'like', '%Sidang%')
                    ->sum('JUMLAH');      

            array_push($sidang, $sidangRes);
            array_push($variable, $variableRes);
            array_push($bimbingan, $bimbinganRes);
            array_push($spp, $sppRes);
            array_push($bulan, $this->generateMonth($date->format('m')));

            $totalSpp       += $sppRes;
            $totalBimbingan += $bimbinganRes;
            $totalVariable  += $variableRes;
            $totalSidang    += $sidangRes;
            
            $date = $dateFrom->addMonth(+1);

        }

        foreach ($bulan as $key => $value) {
            $result[$key]['bulan'] = $value;
            $result[$key]['spp']  = $spp[$key];
            $result[$key]['sidang']  = $sidang[$key];
            $result[$key]['variable']  = $variable[$key];
            $result[$key]['bimbingan']  = $bimbingan[$key];
        }

        $data['totalSpp'] = $totalSpp;
        $data['totalBimbingan'] = $totalBimbingan;
        $data['totalVariable'] = $totalVariable;
        $data['totalSidang'] = $totalSidang;
        $data['jumlah_total'] = $totalSpp + $totalBimbingan + $totalVariable + $totalSidang;
        $data['result'] = $result;

        $data['from'] = Carbon::parse($request->date_from)->format('d F Y');
        $data['to'] = Carbon::parse($request->date_to)->format('d F Y');
        
		if ($request->state == 'result') {
			return view('laporan.rekapitulasi.index', $data);
		}else{
			$pdf = PDF::loadView('laporan.rekapitulasi.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('rekapitulasi.pdf');
		}

    	
    }


    public function generateMonth($month) {

    	switch ($month) {
    		case 1:
    			return 'Januari';
    			break;
    		case 2:
    			return 'Februari';
    			break;
    		case 3:
    			return 'Maret';
    			break;
    		case 4:
    			return 'April';
    			break;
    		case 5:
    			return 'Mei';
    			break;
    		case 6:
    			return 'Juni';
    			break;
    		case 7:
    			return 'Juli';
    			break;
    		case 8:
    			return 'Agustus';
    			break;
    		case 9:
    			return 'September';
    			break;
    		case 10:
    			return 'Oktober';
    			break;
    		case 11:
    			return 'November';
    			break;
    		case 12:
    			return 'Desember';
    			break;
    		
    		default:
    			return '';
    			break;
    	}
    }

}
