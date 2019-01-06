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

                    
                </div>
            </div>
        </div>

	</div>



@endsection
