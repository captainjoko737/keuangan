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
                        <div class="button pull-right">
                            <a type="button" class="btn btn-info btn-sm" href="{{ route('tagihan.create') }}"><i class="fa fa-plus"></i> Tambah </a>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success col-md-6">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger col-md-6">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th>ANGKATAN</th>
                                        <th>SEMESTER</th>
                                        <th>AKADEMIK</th>
                                        <th>PROGRAM STUDI</th>
                                        <th>JUMLAH</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th>ANGKATAN</th>
                                        <th>SEMESTER</th>
                                        <th>AKADEMIK</th>
                                        <th>PROGRAM STUDI</th>
                                        <th>JUMLAH</th>
                                        <th>AKSI</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($result as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['ANGKATAN'] }}</td>
                                            <td>{{ $value['SEMESTER'] }}</td>
                                            <td>{{ $value['AKADEMIK'] }}</td>
                                            <td>{{ $value['prodi']['NAMA_PROGSTUDI'] }}</td>
                                            <td>Rp. {{ number_format($value['JUMLAH'], 2) }}</td>
                                            <td>
                                                <a href="{{ route('tagihan.edit', ['id' => $value->id]) }}" data-toggle="tooltip" data-original-title="Edit" > <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a onclick="drop({{$value->id}})" data-toggle="tooltip" data-original-title="Delete" > <i class="fa fa-trash-o text-danger m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

@endsection

@section('js')
<script type="text/javascript">
    function drop(id) {
        
        var data = {
                "id" : id};

        $(document).ready(function () {
            swal({   
                title: "Are you sure?",   
                text: "You will delete this data",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it !",   
                cancelButtonText: "No, cancel !",   
                closeOnConfirm: false,   
                closeOnCancel: false 
            }, function(isConfirm){   
                if (isConfirm) {    
                    
                    var href = $(this).attr('href');

                    $.ajax({

                        url: '{{ route("tagihan.drop") }}',
                        data: data,
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                        success: function (data) {
                            location.reload();
                        }, error: function (data) {
                            alert(data.responseText);
                        }

                    });
                } else {     
                    swal("Cancelled", "Your data is safe :)", "error");   
                } 
            });
        
        });
    }
</script>
@endsection
