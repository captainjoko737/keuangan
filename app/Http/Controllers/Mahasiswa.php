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
use App\Models\MTagihan;
use Auth;
use View;
use App\Dashboard\Controllers;
use DB;
use Carbon\Carbon;
use PDF;

class Mahasiswa extends Controller
{

    public function index(request $request) {

    	$data['title'] = 'Laporan Per Mahasiswa';

    	return view('laporan.mahasiswa.index', $data);
    }

    public function laporan(request $request) {

    	$data['request'] = $request->all();

    	$data['title'] = 'Laporan Per Mahasiswa';

    	if ($request->state == 'report') {
    		$data['result'] = [];
    	}

    	$result = [];

    	# USER

    	$mahasiswa = MMahasiswa::where('NIM', $request->nim)->first();
    	$PS = MProgramStudi::where('KODE_PROGSTUDI', $mahasiswa['KODE_PROGSTUDI'])->select('NAMA_PROGSTUDI')->first();
    	$mahasiswa['NAMA_PROGSTUDI'] = $PS['NAMA_PROGSTUDI'];
    	$data['mahasiswa'] = $mahasiswa;

    	$mutasi = MMutasi::where('NIM', $request->nim)->get();

    	foreach ($mutasi as $key => $value) {
    		
    		$jnsTrans = MJenisTransaksi::where('jns_trans', $value->JNS_TRANS)->first();
    		$mutasi[$key]['PERIODE_BAYAR'] = $jnsTrans['periode_byr'];
    		
    	}

		$arr = array();

		foreach($mutasi as $key => $value)
		{
			if ($value['PERIODE_BAYAR'] != 'SPP') {
				$arr[$value['JNS_TRANS']][$key] = $value;
			}else{
				$arr[$value['PERIODE_BAYAR']][$key] = $value;
			}
		   	
		}

		foreach ($arr as $key => $value) {
			$sub = [];
			$total = 0;
			$title = '';

			foreach ($value as $keys => $values) {

				array_push($sub, $values);
				$total += $values['JUMLAH'];

				if ($values['PERIODE_BAYAR'] == 'SPP') {
					$value[$keys]['PERIODE_BAYAR'] = $values['JNS_TRANS'];
					$title = 'SPP';
				}else{
					$title = $values['JNS_TRANS'];
				}
				
			}

			$suv['title']	= $title;
			$suv['result'] 	= $sub;
			$suv['total']	= $total;
			array_push($result, $suv);

		}

		$data['result'] = $result;

		if ($request->state == 'result') {
			return view('laporan.mahasiswa.index', $data);
		}else{
			$pdf = PDF::loadView('laporan.mahasiswa.print', $data);
	        $pdf->setPaper('A4', 'potrait');
	        return $pdf->stream('laporan.pdf');
		}
    }

    public function mahasiswa(request $request) {

        $data['title'] = 'Laporan Per Mahasiswa';

        $data['tahun'] = MMahasiswa::distinct('ANGKATAN')->select('ANGKATAN')->where('ANGKATAN', '>=', 2000)->orderBy('ANGKATAN', 'DESC')->get();
        
        if ($request->angkatan) {
            
            $data['id'] = $request->angkatan;

            $tagihan = MTagihan::all();

            $mahasiswa = MMahasiswa::with('prodi')
                ->where('ANGKATAN', $request->angkatan)
                ->select('NIM', 'NAMA', 'KODE_PROGSTUDI', 'ANGKATAN', 'SEMESTER', 'AKADEMIK', 'STATUS', 'POTONGAN')->get();

            foreach ($mahasiswa as $key => $value) {

                if ($value['STATUS'] == 1) {    # AKTIF
                    $mahasiswa[$key]['STATUS'] = 1;

                    $nim      = $value['NIM'];
                    $angkatan = $value['ANGKATAN'];
                    $semester = $value['SEMESTER'];
                    $akademik = $value['AKADEMIK'];
                    $prodi    = $value['KODE_PROGSTUDI'];

                    # GET JUMLAH TAGIHAN

                    foreach ($tagihan as $keys => $values) {
                        
                        # ADD JUMLAH TAGINAN
                        if ($angkatan == $values['ANGKATAN'] && $semester == $values['SEMESTER'] && $akademik == $values['AKADEMIK'] && $prodi == $values['KODE_PROGSTUDI']) {
                            $mahasiswa[$key]['TAGIHAN'] = $values['JUMLAH'] - $value['POTONGAN'];

                            # GET JUMLAH BAYARAN DI SEMESTER INI

                            $pembayaran = MMutasi::where('NIM', $nim)->where('SEMESTER', $semester)->where('TAHUN', $akademik)->sum('JUMLAH');
                            
                            if ($pembayaran >= $values['JUMLAH'] - $value['POTONGAN']) {
                                $mahasiswa[$key]['STATUS_PEMBAYARAN'] = 'LUNAS'; 
                                $mahasiswa[$key]['TUNGGAKAN'] = 0;
                            }else{
                                $mahasiswa[$key]['STATUS_PEMBAYARAN'] = 'BELUM LUNAS';
                                $mahasiswa[$key]['TUNGGAKAN'] = $mahasiswa[$key]['TAGIHAN'] - $pembayaran;
                            }

                            $mahasiswa[$key]['PEMBAYARAN'] = $pembayaran;

                            break;
                        }else{
                            $mahasiswa[$key]['TAGIHAN'] = 0;
                            $mahasiswa[$key]['STATUS_PEMBAYARAN'] = ''; 
                            $mahasiswa[$key]['PEMBAYARAN'] = 0;
                            $mahasiswa[$key]['TUNGGAKAN'] = 0;
                        }

                    }
                }elseif ($value['STATUS'] == 2) { # LULUS
                    $mahasiswa[$key]['STATUS'] = 2;

                    $nim      = $value['NIM'];
                    $angkatan = $value['ANGKATAN'];
                    $semester = $value['SEMESTER'];
                    $akademik = $value['AKADEMIK'];
                    $prodi    = $value['KODE_PROGSTUDI'];

                    # GET JUMLAH TAGIHAN

                    foreach ($tagihan as $keys => $values) {
                        
                        # ADD JUMLAH TAGINAN
                        if ($angkatan == $values['ANGKATAN'] && $semester == $values['SEMESTER'] && $akademik == $values['AKADEMIK'] && $prodi == $values['KODE_PROGSTUDI']) {
                            $mahasiswa[$key]['TAGIHAN'] = $values['JUMLAH'] - $value['POTONGAN'];

                            # GET JUMLAH BAYARAN DI SEMESTER INI

                            $pembayaran = MMutasi::where('NIM', $nim)->where('SEMESTER', $semester)->where('TAHUN', $akademik)->sum('JUMLAH');
                            
                            if ($pembayaran >= $values['JUMLAH'] - $value['POTONGAN']) {
                                $mahasiswa[$key]['STATUS_PEMBAYARAN'] = 'LUNAS'; 
                                $mahasiswa[$key]['TUNGGAKAN'] = 0;
                            }else{
                                $mahasiswa[$key]['STATUS_PEMBAYARAN'] = 'BELUM LUNAS';
                                $mahasiswa[$key]['TUNGGAKAN'] = $mahasiswa[$key]['TAGIHAN'] - $pembayaran;
                            }

                            $mahasiswa[$key]['PEMBAYARAN'] = $pembayaran; 

                            break;
                        }else{
                            $mahasiswa[$key]['TAGIHAN'] = 0;
                            $mahasiswa[$key]['STATUS_PEMBAYARAN'] = ''; 
                            $mahasiswa[$key]['PEMBAYARAN'] = 0;
                            $mahasiswa[$key]['TUNGGAKAN'] = 0;
                        }

                    }
                }else{      # TIDAK AKTIF
                    $mahasiswa[$key]['STATUS'] = 0;
                    $mahasiswa[$key]['TAGIHAN'] = 0;
                    $mahasiswa[$key]['TUNGGAKAN'] = 0;
                }

            }
            $data['result'] = $mahasiswa;

            return view('mahasiswa.data', $data);

        }

    	return view('mahasiswa.index', $data);
    	
    }

    public function detail() {

        $data['title'] = 'Detail Mahasiswa';

        $data['result'] = MMahasiswa::where('NIM', request()->nim)->first();
        
        return view('mahasiswa.detail', $data);
    }

    public function save() {
// return request()->all();

        $data['title'] = 'Detail Mahasiswa';

        $mahasiswa = MMahasiswa::where('NIM', request()->NIM)
                        ->update([
                            'STATUS' => request()->STATUS,
                            'POTONGAN' => request()->POTONGAN,
                        ]);

        // session()->flash('status', 'data mahasiswa berhasil diperbaharui !');
        // $data['result'] = MMahasiswa::where('NIM', request()->NIM)->first();

        // return view('mahasiswa.detail', $data);

       
        return redirect()->route('list.mahasiswa');
    }

}


















































