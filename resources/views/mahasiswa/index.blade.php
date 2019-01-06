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

                        <ul class="nav nav-tabs" role="tablist" id="myTabs">
                            @foreach ($tahun as $key => $value)
                                <li class="nav-item"><a class="nav-link" href="#{{ $value->ANGKATAN }}BISA" data-url="{{ route('list.mahasiswa', ['angkatan' => $value->ANGKATAN])}}" class="media_node active span" data-toggle="tabajax" rel="tooltip"> {{ $value->ANGKATAN }} </a></li>
                            @endforeach
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            @foreach ($tahun as $key => $value)
                                <div class="tab-pane" id="{{ $value->ANGKATAN }}BISA" role="tabpanel"></div>
                            @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript">
        $('#myTabs a').click(function (e) {
            e.preventDefault();

            var url = $(this).attr("data-url");
            var href = this.hash;
            var pane = $(this);

            // ajax load from data-url
            $(href).load(url,function(result){
                pane.tab('show');
            });
        });

      
</script>

@endsection
