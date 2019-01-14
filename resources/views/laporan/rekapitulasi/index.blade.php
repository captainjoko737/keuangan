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
                    	
                        <form role="form" action="{{ route('laporan.rekapitulasi.result') }}" method="POST">
                        	{!! csrf_field() !!}
                            <div class="form-body">
                            	<div class="row">
                            		<!-- <div class="col-md-12">
	                                    <h4 class="card-title m-t-40">Pilih Transaksi</h4>
	                                    <div class="demo-checkbox">
		                                    <input type="checkbox" id="md_checkbox_21" name="transaksi[]" class="filled-in chk-col-blue" value="spp" />
		                                    <label for="md_checkbox_21">SPP</label>
		                                    <input type="checkbox" id="md_checkbox_22" name="transaksi[]" class="filled-in chk-col-blue" value="bimbingan" />
		                                    <label for="md_checkbox_22">BIMBINGAN</label>
		                                    <input type="checkbox" id="md_checkbox_23" name="transaksi[]" class="filled-in chk-col-blue" value="variable" />
		                                    <label for="md_checkbox_23">VARIABLE</label>
		                                    <input type="checkbox" id="md_checkbox_24" name="transaksi[]" class="filled-in chk-col-blue" value="sidang" />
		                                    <label for="md_checkbox_24">SIDANG</label>
		                                </div>
                                    </div> -->
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

	                        		<form role="form" target="_blank" action="{{ route('laporan.rekapitulasi.print') }}" method="GET">
			                        	{!! csrf_field() !!}
			                            <div class="form-body">
			                                <div class="row">
			                            		
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
			                            <br><br>
			                        </form>

	                        	@else
	                        		<p class="card-title text-center">Data Tidak Ditemukan !</p>
	                        	@endif
	                        
		                            <div class="table-responsive">
		                                <table class="table color-bordered-table inverse-bordered-table">
		                                    <thead>
		                                        <tr>
		                                            <th style="width:5%;">No.</th>
		                                            <th>SPP</th>
		                                            <th>BIMBINGAN</th>
		                                            <th>VARIABLE</th>
		                                            <th>SIDANG</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($result as $keys => $values)
			                                    	<tr>
				                                        <td>{{ $keys +1 }}</td>
				                                        <td>Rp. {{ number_format($values['spp'], 2) }}</td>
				                                        <td>Rp. {{ number_format($values['bimbingan'], 2) }}</td>
				                                        <td>Rp. {{ number_format($values['variable'], 2) }}</td>
				                                        <td>Rp. {{ number_format($values['sidang'], 2) }}</td>
				                                        
			                                      	<tr>
		                                        @endforeach
		                                    </tbody>
		                                    <tfoot>
		                                    	<tr>
		                                    		<th></th>
		                                            <th>Rp. {{ number_format($totalSpp, 2) }}</th>
		                                            <th>Rp. {{ number_format($totalBimbingan, 2) }}</th>
		                                            <th>Rp. {{ number_format($totalVariable, 2) }}</th>
		                                            <th>Rp. {{ number_format($totalSidang, 2) }}</th>
		                                        </tr>
		                                    </tfoot>
		                                </table>
		                                
		                            </div>
		                        @if ($result)
		                        <table class="table color-bordered-table inverse-bordered-table">
                                	<thead>
                                        <tr>
                                        	<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                            <th></th>
                                            <th>Jumlah Raya</th>
                                            <th>Rp. {{ number_format($jumlah_total, 2) }}</th>
                                        </tr>
                                    </thead>
                                </table>
                                @endif
		                        
	                        </div>
	                    </div>
	                @endif
                </div>
            </div>
        </div>

	</div>



@endsection
