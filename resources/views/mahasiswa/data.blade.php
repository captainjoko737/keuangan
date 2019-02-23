<script type="text/javascript">

    var id_table = {!! json_encode($id) !!};

    $(document).ready(function() {
            $('table.display').DataTable();
        } );

        $(".select2").select2();
        $('.selectpicker').selectpicker();

        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#'+id_table).DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel',
            ]
        });
</script>

<div class="table-responsive m-t-40">
    <h4><strong>Angkatan : {{ $id }} </strong></h4>
    <table id="{{ $id }}" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>PROGRAM STUDI</th>
                <th>ANGKATAN</th>
                <th>SEMESTER</th>
                <th>AKADEMIK</th>
                <th>STATUS MHS</th>
                <th>POTONGAN</th>
                <th>TAGIHAN</th>
                <th>PEMBAYARAN</th>
                <th>TUNGGAKAN</th>
                <th>STATUS PEMBAYARAN</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:5%;">No.</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>PROGRAM STUDI</th>
                <th>ANGKATAN</th>
                <th>SEMESTER</th>
                <th>AKADEMIK</th>
                <th>STATUS MHS</th>
                <th>POTONGAN</th>
                <th>TAGIHAN</th>
                <th>PEMBAYARAN</th>
                <th>TUNGGAKAN</th>
                <th>STATUS PEMBAYARAN</th>
                <th>AKSI</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($result as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value['NIM'] }}</td>
                    <td>{{ $value['NAMA'] }}</td>
                    <td>{{ $value['prodi']['NAMA_PROGSTUDI'] }}</td>
                    <td>{{ $value['ANGKATAN'] }}</td>
                    <td>{{ $value['SEMESTER'] }}</td>
                    <td>{{ $value['AKADEMIK'] }}</td>
                    @if ($value['STATUS'] == 1)
                        <td>AKTIF</td>
                    @elseif ($value['STATUS'] == 0)
                        <td>TIDAK AKTIF</td>
                    @elseif ($value['STATUS'] == 2)
                        <td>LULUS</td>
                    @endif
                    
                    @if ($value['POTONGAN'] == null)
                        <td>Rp. 0.00</td>
                    @else
                        <td>Rp. {{ number_format($value['POTONGAN'], 2) }}</td>
                    @endif

                    <td>Rp. {{ number_format($value['TAGIHAN'], 2) }}</td>
                    <td>Rp. {{ number_format($value['PEMBAYARAN'], 2) }}</td>
                    <td>Rp. {{ number_format($value['TUNGGAKAN'], 2) }}</td>
                    <td>{{ $value['STATUS_PEMBAYARAN'] }}</td>
                    <td>
                        <a href="{{ route('mahasiswa.detail', ['nim' => $value->NIM]) }}" data-toggle="tooltip" data-original-title="Detail" > <i class="fa fa-search text-inverse m-r-10"></i> </a>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>