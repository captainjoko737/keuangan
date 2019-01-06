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

                        {!! csrf_field() !!}
    
                        {!! Form::open(array('route' => 'mahasiswa.save','files'=>true)) !!}
                        <div class="form-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>NIM</h5>
                                        <input type="text" id="NIM" name="NIM" class="form-control" style="width: 30%; height:56px;" placeholder="" value="{{ $result->NIM }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>NAMA</h5>
                                        <input type="text" id="NAMA" name="NAMA" class="form-control" style="width: 30%; height:56px;" placeholder="" value="{{ $result->NAMA }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>STATUS</h5>
                                        <select class="select2 form-control custom-select" name="STATUS" style="width: 30%; height:56px;" required>
                                            <option> </option>
                                            <option value="1" {{ $result['STATUS'] == '1' ? "selected" : "" }}>Aktif</option>
                                            <option value="0" {{ $result['STATUS'] == '0' ? "selected" : "" }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>POTONGAN</h5>
                                        <input type="text" id="POTONGAN" name="POTONGAN" class="form-control" style="width: 30%; height:56px;" placeholder="Masukan Potongan" value="{{ $result->POTONGAN }}">
                                    </div>
                                </div>
                            </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-inverse">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection


