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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = 'Dashboard';

        
        $mhsAktif = 0;
        $mhsTidakAktif = 0;
        $mhsLulus = 0;
        $mhsSudahBayar = 0;
        $mhsBelumBayar = 0;

        $tagihan = MTagihan::all();

        $mahasiswaResult = MMahasiswa::select('NIM', 'NAMA', 'ANGKATAN', 'SEMESTER', 'AKADEMIK', 'STATUS', 'POTONGAN')->get();

        foreach ($mahasiswaResult as $key => $value) {

            if ($value['STATUS'] == 1) {

                $mhsAktif += 1;
                $mahasiswaResult[$key]['STATUS'] = 1;

                $nim      = $value['NIM'];
                $angkatan = $value['ANGKATAN'];
                $semester = $value['SEMESTER'];
                $akademik = $value['AKADEMIK'];

                # GET JUMLAH TAGIHAN

                foreach ($tagihan as $keys => $values) {
                    
                    # ADD JUMLAH TAGINAN
                    if ($angkatan == $values['ANGKATAN'] && $semester == $values['SEMESTER'] && $akademik == $values['AKADEMIK']) {

                        $mahasiswaResult[$key]['TAGIHAN'] = $values['JUMLAH'] - $value['POTONGAN'];

                        # GET JUMLAH BAYARAN DI SEMESTER INI

                        $pembayaran = MMutasi::where('NIM', $nim)->where('SEMESTER', $semester)->where('TAHUN', $akademik)->sum('JUMLAH');

                        if ($pembayaran >= $values['JUMLAH'] - $value['POTONGAN']) {
                            $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = 'LUNAS'; 
                        }else{
                            $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = 'BELUM LUNAS';
                        }

                        $mahasiswaResult[$key]['PEMBAYARAN'] = $pembayaran; 

                        break;
                    }else{
                        $mahasiswaResult[$key]['TAGIHAN'] = 0;
                        $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = ''; 
                        $mahasiswaResult[$key]['PEMBAYARAN'] = 0;
                    }

                }
            }elseif ($value['STATUS'] == 2) {

                $mhsLulus += 1;
                $mahasiswaResult[$key]['STATUS'] = 2;

                $nim      = $value['NIM'];
                $angkatan = $value['ANGKATAN'];
                $semester = $value['SEMESTER'];
                $akademik = $value['AKADEMIK'];

                # GET JUMLAH TAGIHAN

                foreach ($tagihan as $keys => $values) {
                    
                    # ADD JUMLAH TAGINAN
                    if ($angkatan == $values['ANGKATAN'] && $semester == $values['SEMESTER'] && $akademik == $values['AKADEMIK']) {

                        $mahasiswaResult[$key]['TAGIHAN'] = $values['JUMLAH'] - $value['POTONGAN'];

                        # GET JUMLAH BAYARAN DI SEMESTER INI

                        $pembayaran = MMutasi::where('NIM', $nim)->where('SEMESTER', $semester)->where('TAHUN', $akademik)->sum('JUMLAH');

                        if ($pembayaran >= $values['JUMLAH'] - $value['POTONGAN']) {
                            $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = 'LUNAS'; 
                        }else{
                            $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = 'BELUM LUNAS';
                        }

                        $mahasiswaResult[$key]['PEMBAYARAN'] = $pembayaran; 
// return $pembayaran;
                        break;
                    }else{
                        $mahasiswaResult[$key]['TAGIHAN'] = 0;
                        $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = ''; 
                        $mahasiswaResult[$key]['PEMBAYARAN'] = 0;
                    }

                }
            }else{
                $mhsTidakAktif += 1;
                $mahasiswaResult[$key]['STATUS'] = 0;
                $mahasiswaResult[$key]['TAGIHAN'] = 0;
                $mahasiswaResult[$key]['STATUS_PEMBAYARAN'] = ''; 
                $mahasiswaResult[$key]['PEMBAYARAN'] = 0;
            }

        }

        foreach ($mahasiswaResult as $key => $value) {
            
            if ($value['STATUS'] == 1) {
                if ($value['STATUS_PEMBAYARAN'] == 'LUNAS') {
                    $mhsSudahBayar += $value['PEMBAYARAN'];
                }else{
                    $mhsSudahBayar += $value['PEMBAYARAN'];
                    $mhsBelumBayar += $value['TAGIHAN'] - $value['PEMBAYARAN'];
                }
            }elseif ($value['STATUS'] == 2) {
                // return $value;
                if ($value['STATUS_PEMBAYARAN'] == 'LUNAS') {
                    $mhsSudahBayar += $value['PEMBAYARAN'];
                }else{
                    $mhsSudahBayar += $value['PEMBAYARAN'];
                    $mhsBelumBayar += $value['TAGIHAN'] - $value['PEMBAYARAN'];
                }
            }

        }

// return $mhsSudahBayar;


        $data['mahasiswa_aktif'] = $mhsAktif;
        $data['mahasiswa_tidak_aktif'] = $mhsTidakAktif;
        $data['mahasiswa_lulus'] = $mhsLulus;
        $data['mahasiswa_sudah_bayar'] = $mhsSudahBayar;
        $data['mahasiswa_belum_bayar'] = $mhsBelumBayar;

        # BAYARAN PER TAHUN 
        $resultMutasi = MMutasi::select(DB::raw("YEAR(TGL_TRANS) as year, SUM(JUMLAH) as JUMLAH"))
                    ->orderBy('year', 'DESC')
                    ->groupBy(DB::raw("YEAR(TGL_TRANS)"))
                    ->get();

        $datasetMutasi = [];
        $labelMutasi   = [];

        foreach ($resultMutasi as $key => $value) {
            $datasetMutasi[$key]['value'] = $value['JUMLAH'];
            $labelMutasi[$key]['label']   = (string)$value['year'];
        }

        $data['dataset_mutasi'] = $datasetMutasi;
        $data['label_mutasi']   = $labelMutasi;

        $programStudi = MProgramStudi::all();
        $tahun = MMahasiswa::distinct('ANGKATAN')->select('ANGKATAN')->where('ANGKATAN', '>=', 2000)->orderBy('ANGKATAN', 'DESC')->get();

        $categories = [];
        $category = [];
        $dataset  = [];

        foreach ($tahun as $key => $value) {
            $category[$key]['label'] = (string)$value['ANGKATAN'];
        }




        $series = [];
        $tahunan = [];
        foreach ($programStudi as $key => $value) {
           
            $series[$key]['seriesname'] = $value['KODE_PROGSTUDI'];

            $res = [];
            foreach ($tahun as $keys => $values) {
                // $programStudiMahasiswa = MMahasiswa::where('mahasiswa.KODE_PROGSTUDI', $value['KODE_PROGSTUDI'])->where('mahasiswa.ANGKATAN', $values['ANGKATAN'])->join('mutasi', 'mutasi.NIM', '=', 'mahasiswa.NIM')->get();

                $mutasi = MMutasi::where('mahasiswa.ANGKATAN', $values['ANGKATAN'])
                        ->join('mahasiswa', 'mahasiswa.NIM', '=', 'mutasi.NIM')
                        ->where('mahasiswa.KODE_PROGSTUDI', $value['KODE_PROGSTUDI'])
                        ->sum('mutasi.JUMLAH');
                
                $res[$keys]['value'] = $mutasi;
            }
            $series[$key]['data'] = $res;

        }

        $tahunan = [];
        foreach ($series as $key => $value) {
            foreach ($value['data'] as $keys => $values) {
                if (isset($tahunan[$keys])) {
                    $tahunan[$keys]['value'] += $values['value'];
                }else{
                    $tahunan[$keys]['value'] = $values['value'];
                }
            }
        }

        $data['dataset_tahunan'] = $tahunan;
        $data['category'] = $category;
        $data['dataset'] = $series;

        return view('home', $data);
    }
}


