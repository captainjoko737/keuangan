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
                            <div class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! csrf_field() !!}
    
                        {!! Form::open(array('route' => 'tagihan.save','files'=>true)) !!}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>ANGKATAN</h5>
                                        <select class="select2 form-control custom-select" name="angkatan" style="width: 30%; height:56px;" required>
                                            <option> </option>
                                            @foreach ($angkatan as $key => $value)
                                                <option value="{{ $value->ANGKATAN }}" {{ $result['ANGKATAN'] == $value['ANGKATAN'] ? "selected" : "" }}>{{ $value->ANGKATAN }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>SEMESTER</h5>
                                        <select class="select2 form-control custom-select" name="semester" style="width: 30%; height:56px;" required>
                                            @foreach ($semester as $key => $value)
                                                <option> </option>
                                                <option value="{{ $value->SEMESTER }}" {{ $result['SEMESTER'] == $value['SEMESTER'] ? "selected" : "" }}>{{ $value->SEMESTER }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>AKADEMIK</h5>
                                        <select class="select2 form-control custom-select" name="akademik" style="width: 30%;" required>
                                            @foreach ($akademik as $key => $value)
                                                <option> </option>
                                                <option value="{{ $value->AKADEMIK }}" {{ $result['AKADEMIK'] == $value['AKADEMIK'] ? "selected" : "" }}>{{ $value->AKADEMIK }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>JUMLAH TAGIHAN</h5>
                                        <input type="text" id="id" name="id" class="form-control" hidden style="width: 30%; height:56px;" placeholder="Jumlah Tagihan" value="{{ $result->id }}">
                                        <input type="text" id="jumlah" name="jumlah" class="form-control" style="width: 30%; height:56px;" placeholder="Jumlah Tagihan" value="{{ $result->JUMLAH }}">
                                    </div>
                                </div>
                                        
                            </div>


                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a type="button" href="{{ route('tagihan') }}" class="btn btn-inverse">Cancel</a>
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


