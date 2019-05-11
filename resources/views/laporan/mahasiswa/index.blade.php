@extends('layouts.app')

@section('content')

	<div class="page-wrapper">
            
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-default">
                        <h4 class="m-b-0 text-black">{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                    	
                        <form role="form" action="{{ route('laporan.mahasiswa.result') }}" method="POST">
                        	{!! csrf_field() !!}
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">NIM</label>
                                            <input type="text" id="nim" name="nim" class="form-control" placeholder="NIM" value="{{ isset($request['nim']) ? $request['nim'] : '410321'  }}">
                                            <input type="text" id="state" name="state" class="form-control" hidden value="result">
                                            <small class="form-control-feedback"> Masukkan NIM </small> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" readonly value="{{ isset($mahasiswa['NAMA']) ? $mahasiswa['NAMA'] : ''  }}">
                                       	</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Program Studi</label>
                                            <input type="text" id="program_studi" name="program_studi" class="form-control" placeholder="Program Studi" readonly value="{{ isset($mahasiswa['NAMA_PROGSTUDI']) ? $mahasiswa['NAMA_PROGSTUDI'] : ''  }}">
                                       	</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Angkatan</label>
                                            <input type="text" id="angkatan" name="angkatan" class="form-control" placeholder="Angkatan" readonly value="{{ isset($mahasiswa['ANGKATAN']) ? $mahasiswa['ANGKATAN'] : ''  }}">
                                       	</div>	
                                    </div>
                                    <!--/span-->
                                    
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-search"></i> Cari Data</button>
                            </div>
                        </form>
                    </div>

                    @if (isset($result))
	                    <div class="card">
	                        <div class="card-body">
	                        	@if ($result)

	                        		<form role="form" target="_blank" action="{{ route('laporan.mahasiswa.print') }}" method="GET">
			                        	{!! csrf_field() !!}
			                            <div class="form-body">
			                                <div class="row p-t-20">
			                                    <div class="col-md-3">
			                                        <div class="form-group" hidden>
			                                            <label class="control-label">NIM</label>
			                                            <input type="text" id="nim" name="nim" class="form-control" placeholder="NIM" value="{{ isset($request['nim']) ? $request['nim'] : '410321'  }}">
			                                            <input type="text" id="state" name="state" class="form-control" hidden value="report">
			                                            <small class="form-control-feedback"> Masukkan NIM </small> </div>
			                                    </div>
			                                    
			                                </div>
			                            </div>
			                            <div class="form-actions">
			                                <button type="submit" class="btn btn-info btn-sm pull-right"> <i class="fa fa-print"></i> Cetak</button>
			                            </div>
			                        </form>

	                        	@else
	                        		<p class="card-title text-center">Data Tidak Ditemukan !</p>
	                        	@endif
	                        	
	                            @foreach ($result as $key => $value)
		                            <h4 class="card-title">{{ $value['title'] }}</h4>
		                            <div class="table-responsive">
		                                <table class="table color-bordered-table inverse-bordered-table">
		                                    <thead>
		                                        <tr>
		                                            <th style="width:5%;">No.</th>
		                                            <th>Tanggal</th>
		                                            <th>No. Kwitansi</th>
		                                            <th>Transaksi</th>
		                                            <th>Periode Bayar</th>
		                                            <th>Jumlah</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($value['result'] as $keys => $values)
			                                        <tr>
			                                            <td>{{ $keys + 1 }}</td>
			                                            <td>{{ $values['TGL_TRANS']->format('d M Y H:i:s') }}</td>
			                                            <td>{{ $values['NO_KWITANSI'] }}</td>
			                                            <td>{{ $values['PERIODE_BAYAR'] }}</td>
			                                            <td>Semester {{ $values['SEMESTER'] }}</td>
			                                            <td>{{ number_format($values['JUMLAH'], 2) }}</td>
			                                        </tr>
		                                        @endforeach
		                                    </tbody>
		                                    <tfoot>
		                                    	<tr>
		                                    		<td></td>
		                                            
		                                            <td></td>
		                                            <td></td>
		                                            <td></td>
		                                            <th>Jumlah Total</th>
		                                            <th>Rp. {{ number_format($value['total'], 2) }}</th>
		                                        </tr>
		                                    </tfoot>
		                                </table>
		                            </div>
		                        @endforeach
		                        <h4 class="card-title">TOTAL KESELURUHAN</h4>
		                        <div class="table-responsive">
		                                <table class="table color-bordered-table inverse-bordered-table">
		                                    <thead>
		                                        <tr>
		                                            <th>Rp. {{ number_format($total_keseluruhan, 2) }}</th> 
		                                        </tr>
		                                    </thead>
		                                    
		                                </table>
		                            </div>
	                        </div>
	                    </div>
	                @endif
                </div>
            </div>
        </div>

	</div>



@endsection
