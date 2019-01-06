@extends('layouts.app')

@section('content')
<div class="page-wrapper">
            
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-default">
                    <h4 class="m-b-0 text-black">{{ $title }}</h4>
                </div>
               
            </div>
        </div>
    </div>

    <div class="container-fluid">

            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="m-r-10 align-self-center"><img src="{{ url('public/assets/images/icon/income-w.png') }}" alt="Income" /></div>
                                <div class="align-self-center">
                                    <h6 class="text-white m-t-10 m-b-0"><strong>Mahasiswa Lunas</strong></h6>
                                    <h5 class="m-t-0 text-white"><strong>Rp. {{ number_format($mahasiswa_sudah_bayar, 2) }} </strong></h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="m-r-10 align-self-center"><img src="{{ url('public/assets/images/icon/income-w.png') }}" alt="Income" /></div>
                                <div class="align-self-center">
                                    <h6 class="text-white m-t-10 m-b-0"><strong>Tunggakan</strong></h6>
                                    <h5 class="m-t-0 text-white"><strong>Rp. {{ number_format($mahasiswa_belum_bayar, 2) }}</strong></h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="m-r-10 align-self-center"><img src="{{ url('public/assets/images/icon/staff-w.png') }}" alt="Income" /></div>
                                <div class="align-self-center">
                                    <h6 class="text-white m-t-10 m-b-0"><strong>Mahasiswa Aktif</strong></h6>
                                    <h5 class="m-t-0 text-white"><strong>{{ $mahasiswa_aktif }}</strong></h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="m-r-10 align-self-center"><img src="{{ url('public/assets/images/icon/staff-w.png') }}" alt="Income" /></div>
                                <div class="align-self-center">
                                    <h6 class="text-white m-t-10 m-b-0"><strong>Mahasiswa Non Aktif</strong></h6>
                                    <h5 class="m-t-0 text-white"><strong>{{ $mahasiswa_tidak_aktif }}</strong></h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

  			<div class="row">
                <!-- <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><span class="lstick"></span>Visit Separation</h4>
                            <div id="visitor" style="height:290px; width:100%;"></div>
                            <table class="table vm font-14">
                                <tr>
                                    <td class="b-0">Mobile</td>
                                    <td class="text-right font-medium b-0">38.5%</td>
                                </tr>
                                <tr>
                                    <td>Tablet</td>
                                    <td class="text-right font-medium">30.8%</td>
                                </tr>
                                <tr>
                                    <td>Desktop</td>
                                    <td class="text-right font-medium">7.7%</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-right font-medium">23.1%</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>
            <div id="chart-container-2"></div>
            <br>
            <div id="chart-container-1"></div>
            <br>
            <div id="chart-container"></div>
            <br>
            
                        
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            
        </div>

	</div>
@endsection

@section('js')
<script type="text/javascript">

	var category = {!! json_encode($category) !!};
    var dataset = {!! json_encode($dataset) !!};
    var dataset_tahunan = {!! json_encode($dataset_tahunan) !!};

    var dataset_mutasi = {!! json_encode($dataset_mutasi) !!};
    var label_mutasi = {!! json_encode($label_mutasi) !!};

        const mutasi = {
          "chart": {
            "caption": "MUTASI TAHUNAN",
            "subcaption": "",
            "yaxisname": "",
            "numvisibleplot": "0",
            "numberPrefix": "Rp. ",
            "formatNumberScale": "40",
            "rotateValues": "0",
            "showValues": "0",
            "placeValuesInside": "1",
            "thousandSeparatorPosition": "3,3",
            "theme": "fusion"
          },
          "categories": [
            {
              "category": label_mutasi
            }
          ],
          "dataset": [{
                "seriesname": "",
                "data": dataset_mutasi
              }
           ]
        };

        

        FusionCharts.ready(function() {
           var myChart = new FusionCharts({
              type: "msline",
              renderAt: "chart-container-2",
              width: "100%",
              height: "80%",
              dataFormat: "json",
              dataSource : mutasi
           }).render();
        });
	
		const prodi = {
		  "chart": {
		    "caption": "PROGRAM STUDI (ANGKATAN)",
		    "subcaption": "",
		    "yaxisname": "",
		    "numvisibleplot": "0",
		    "numberPrefix": "Rp. ",
		    "formatNumberScale": "40",
            "rotateValues": "0",
            "showValues": "0",
            "placeValuesInside": "1",
		    "thousandSeparatorPosition": "3,3",
		    "theme": "fusion"
		  },
		  "categories": [
		    {
		      "category": category
		    }
		  ],
		  "dataset": dataset
		};

		

		FusionCharts.ready(function() {
		   var myChart = new FusionCharts({
		      type: "msline",
		      renderAt: "chart-container-1",
		      width: "100%",
		      height: "50%",
		      dataFormat: "json",
		      dataSource : prodi
		   }).render();
		});

		const tahunan = {
		  "chart": {
		    "caption": "TAHUNAN (ANGKATAN)",
		    "subcaption": "",
		    "yaxisname": "",
		    "numvisibleplot": "0",
		    "numberPrefix": "Rp. ",
		    "formatNumberScale": "40",
            "rotateValues": "0",
            "showValues": "0",
            "placeValuesInside": "1",
		    "thousandSeparatorPosition": "3,3",
		    "theme": "fusion"
		  },
		  "categories": [
		    {
		      "category": category
		    }
		  ],
		  "dataset": [{
	            "seriesname": "",
	            "data": dataset_tahunan
	          }
	       ]
		};

		FusionCharts.ready(function() {
		   var myChart = new FusionCharts({
		      type: "msline",
		      renderAt: "chart-container",
		      width: "100%",
		      height: "30%",
		      dataFormat: "json",
		      dataSource : tahunan
		   }).render();
		});

	// var chart = c3.generate({
 //        bindto: '#visitor',
 //        data: {
 //            columns: [
 //                ['Other', 30],
 //                ['Desktop', 10],
 //                ['Tablet', 40],
 //                ['Mobile', 50],
 //            ],
            
 //            type : 'donut',
 //            onclick: function (d, i) { console.log("onclick", d, i); },
 //            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
 //            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
 //        },
 //        donut: {
 //            label: {
 //                show: false
 //              },
 //            title:"Visits",
 //            width:20,
            
 //        },
        
 //        legend: {
 //          hide: true
 //          //or hide: 'data1'
 //          //or hide: ['data1', 'data2']
 //        },
 //        color: {
 //              pattern: ['#eceff1', '#745af2', '#26c6da', '#1e88e5']
 //        }
 //    });
</script>
@endsection
