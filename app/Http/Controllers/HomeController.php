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

        #Mahasiswa Aktif diambil dari table mahasiswa di bawah semester 14
        $data['mahasiswa_aktif'] = MMahasiswa::where('SEMESTER', '<=', 8)->get()->count();

        # Mahasiswa Tidak Aktif diambil dari table mahasiswa di atas semester 14
        $data['mahasiswa_tidak_aktif'] = MMahasiswa::where('SEMESTER', '>', 8)->get()->count();


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


