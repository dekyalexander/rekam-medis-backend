<!-- <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100">
<h2>Rekap Data Sisa Obat</h2>
<h3>Unit Kesehatan Sekolah</h3>
<h4>Sekolah Terpadu Pahoa</h4>
<h5>Jalan Ki Hajar Dewantara No. 1 Summarecon Serpong - Tangerang 15810</h5> -->
<table>
    <thead>
        <th> </th>
        <th> <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100"> </th>
        <th  colspan='10' style="font-weight: bold;  vertical-align: center; font-size: 14px;" > Rekap Data Sisa Obat </th>
    </thead>
</table>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Obat</th>
        <th>Lokasi Obat</th>
        <th>Obat Keluar</th>
        <th>Sisa Obat</th>
        <th>Keterangan</th>
        <th>Tanggal Expired Obat</th>
        <th>Tanggal Transaksi</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 0;?>
    @foreach($Drug as $drug)
    <?php $no++ ;?>
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $drug->drugname->drug_name }}</td>
            <td>{{ $drug->listofukslocations->uks_name }}</td>
            <td>{{ $drug->qty_take }}</td>
            <td>{{ $drug->leftover_qty }}</td>
            <td>{{ $drug->description }}</td>
            <td>{{ date('d-m-Y', strtotime( $drug->date_expired)) }}</td>
            <td>{{ date('d-m-Y', strtotime( $drug->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>