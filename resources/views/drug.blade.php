<!-- <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100">
<h2>Rekap Data Obat Masuk</h2>
<h3>Unit Kesehatan Sekolah</h3>
<h4>Sekolah Terpadu Pahoa</h4>
<h5>Jalan Ki Hajar Dewantara No. 1 Summarecon Serpong - Tangerang 15810</h5> -->
<table>
    <thead>
        <th> </th>
        <th> <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100"> </th>
        <th  colspan='10' style="font-weight: bold;  vertical-align: center; font-size: 14px;" > Rekap Data Obat Masuk </th>
    </thead>
</table>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Jenis Obat</th>
        <th>Nama Obat</th>
        <th>Satuan Obat</th>
        <th>Tanggal Expired Obat</th>
        <th>Lokasi Obat</th>
        <th>Jumlah Obat</th>
        <th>Keterangan</th>
        <th>Tanggal Masuk Obat</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 0;?>
    @foreach($Drug as $drug)
    <?php $no++ ;?>
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $drug->drugtype->drug_type }}</td>
            <td>{{ $drug->drugname->drug_name }}</td>
            <td>{{ $drug->drugunit->drug_unit }}</td>
            <td>{{ date('d-m-Y', strtotime( $drug->drugexpired->date_expired)) }}</td>
            <td>{{ $drug->locationdrug->listofukslocations->uks_name }}</td>
            <td>{{ $drug->stocks->qty }}</td>
            <td>{{ $drug->description }}</td>
            <td>{{ date('d-m-Y', strtotime( $drug->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>