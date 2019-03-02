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
                    	
                        <form role="form" action="{{ route('laporan.kasir.result') }}" method="POST">
                        	{!! csrf_field() !!}
                            <div class="form-body">
                            	<div class="row">
                            		<div class="col-md-6">
                                        <h5 class="m-t-30 m-b-10">Pilih Kasir</h5>
	                                        
	                                    <select class="select2 form-control custom-select" name="nama" style="width: 100%; height:36px;" required>
		                                    <option> </option>
		                                    @foreach ($kasir as $key => $value)
		                                    	<option value="{{ $value->NAMA }}" {{ isset($request) ? ($request['nama'] == $value['NAMA']) ? "selected" : "" : "" }}> {{ $value->NAMA }}</option>
		                                    @endforeach
		                                </select>
                                    </div>
                                </div>
                            	<div class="row">
                                    <div class="col-md-4">
                                        <h5 class="m-t-30 m-b-10">Periode</h5>
                                        <input class="form-control" type="date" name="date_from" value="{{ isset($request) ? $request['date_from'] : "" }}" id="example-date-input" required>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="m-t-30 m-b-10">Periode</h5>
                                        <input class="form-control" type="date" name="date_to" value="{{ isset($request) ? $request['date_to'] : "" }}" id="example-date-input" required>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <input type="text" id="state" name="state" class="form-control" hidden value="result">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-search"></i> Cari Data</button>
                            </div>
                        </form>
                    </div>

                    @if (isset($result))
	                    <div class="card">
	                        <div class="card-body">
	                        	@if ($result)

	                        		<form role="form" target="_blank" action="{{ route('laporan.kasir.print') }}" method="GET">
			                        	{!! csrf_field() !!}
			                            <div class="form-body">
			                                <div class="row">
			                            		<div class="col-md-6" hidden>
			                                        <h5 class="m-t-30 m-b-10">Pilih Kasir</h5>
	                                        
				                                    <select class="select2 form-control custom-select" name="nama" style="width: 100%; height:36px;" required>
					                                    <option> </option>
					                                    @foreach ($kasir as $key => $value)
					                                    	<option value="{{ $value->NAMA }}" {{ isset($request) ? ($request['nama'] == $value['NAMA']) ? "selected" : "" : "" }}> {{ $value->NAMA }}</option>
					                                    @endforeach
					                                </select>
			                                    </div>
			                                </div>
			                            	<div class="row" hidden>
			                                    <div class="col-md-4">
			                                        <h5 class="m-t-30 m-b-10">Periode</h5>
			                                        <input class="form-control" type="date" name="date_from" value="{{ isset($request) ? $request['date_from'] : "" }}" id="example-date-input">
			                                    </div>
			                                    <div class="col-md-4">
			                                        <h5 class="m-t-30 m-b-10">Periode</h5>
			                                        <input class="form-control" type="date" name="date_to" value="{{ isset($request) ? $request['date_to'] : "" }}" id="example-date-input">
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
		                                            <th>Nama</th>
		                                            <th>NIM</th>
		                                            <th>Tanggal</th>
		                                            <th>No. Kwitansi</th>
		                                            <th>Jenis Transaksi</th>
		                                            <th>Nilai Transaksi</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($value['result'] as $keys => $values)
			                                    	<tr>
				                                        <td>{{ $keys +1 }}</td>
				                                        <td>{{ $values['NAMA'] }}</td>
				                                        <td>{{ $values['NIM'] }}</td>
				                                        <td>{{ $values['TGL_TRANS'] }}</td>
				                                        <td>{{ $values['NO_KWITANSI'] }}</td>
				                                        <td>{{ $values['JNS_TRANS'] }}</td>
				                                        <td>Rp. {{ number_format($values['JUMLAH'], 2) }}</td>
			                                      	<tr>
		                                        @endforeach
		                                    </tbody>
		                                    <tfoot>
		                                    	<tr>
		                                    		
		                                            <td></td>
		                                            <th>Jumlah Total</th>
		                                            <th>Rp. {{ number_format($value['total'], 2) }}</th>
		                                        </tr>
		                                    </tfoot>
		                                </table>
		                                
		                            </div>
		                        @endforeach
		                        
	                        </div>
	                    </div>
	                @endif
                </div>
            </div>
        </div>

	</div>



@endsection
