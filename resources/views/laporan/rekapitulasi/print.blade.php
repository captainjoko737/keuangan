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
  /*text-align: left;*/
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

      <center><h5>REKAPITULASI PENERIMAAN</h5></center>
      <center><h5>Per {{ $from }} sampai {{ $to }}</h5></center>
      
      <br>
      <hr>
      <table>
        <tr>
            <th style="width:5%;">No.</th>
            <th>SPP</th>
            <th>BIMBINGAN</th>
            <th>VARIABLE</th>
            <th>SIDANG</th>
        </tr>

        @foreach ($result as $keys => $values)
          <tr>
            <td>{{ $keys +1 }}</td>
            <td>Rp. {{ number_format($values['spp'], 2) }}</td>
            <td>Rp. {{ number_format($values['bimbingan'], 2) }}</td>
            <td>Rp. {{ number_format($values['variable'], 2) }}</td>
            <td>Rp. {{ number_format($values['sidang'], 2) }}</td>
          </tr>
        @endforeach
        
        <tr>
            <th></th>
            <th>Rp. {{ number_format($totalSpp, 2) }}</th>
            <th>Rp. {{ number_format($totalBimbingan, 2) }}</th>
            <th>Rp. {{ number_format($totalVariable, 2) }}</th>
            <th>Rp. {{ number_format($totalSidang, 2) }}</th>
        </tr>
      </table>

    <br>
    <table>
      <tr>
         
          <th>Jumlah Raya</th>
          <th style="width:30%;">Rp. {{ number_format($jumlah_total, 2) }}</th>
      </tr>
    </table>
  
<div id="footer">
  <div class="page-number"></div>
</div>


  </body>
</html>
