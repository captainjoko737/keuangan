<!DOCTYPE html>
<html>
<head>
  <title>KEUANGAN FKIP</title>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  font-size: 12px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

table#t01 tr:nth-child(even) {
  background-color: black;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  border-color: transparent;
  background-color: transparent;
  color: black;
}

h5{
  margin-bottom: 5px;
}

#header,
#footer {
  position: fixed;
  left: 0;
  right: 0;
  color: #000;
  font-size: 0.9em;
}
#header {
  top: 0;
  border-bottom: 0.1pt solid #000;
}
#footer {
  bottom: 0;
  border-top: 0.1pt solid #000;
}
.page-number:before {
  content: "Halaman " counter(page);
}

</style>
</head>
  <body>

    <center><img src="{{ base_path() }}/public/images/header.jpg" alt="" width="75%"> </center>
    <hr>
    <pre>
NIM           :  {{ $request['nim'] }}
NAMA          :  {{ $mahasiswa['NAMA'] }}
PROGRAM STUDI :  {{ $mahasiswa['NAMA_PROGSTUDI'] }}
ANGKATAN      :  {{ $mahasiswa['ANGKATAN'] }}
    </pre> 

        @foreach ($result as $key => $value)
          <h5>{{ $value['title'] }}</h5>
          <table>
            <tr>
                <th style="width:5%;">No.</th>
                <th>Tanggal</th>
                <th>No. Kwitansi</th>
                <th>Transaksi</th>
                <th>Periode Bayar</th>
                <th>Jumlah</th>
            </tr>
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
            <tr>
              <td></td>
                  
                  <td></td>
                  <td></td>
                  <td></td>
                  <th>Jumlah Total</th>
                  <th>Rp. {{ number_format($value['total'], 2) }}</th>
              </tr>
          </table>
        @endforeach

        <div id="footer">
          <div class="page-number"></div>
        </div>

  </body>
</html>
