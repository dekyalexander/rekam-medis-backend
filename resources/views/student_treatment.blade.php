<!-- <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100">
<h2>Rekap Data Berobat Siswa</h2>
<h3>Unit Kesehatan Sekolah</h3>
<h4>Sekolah Terpadu Pahoa</h4>
<h5>Jalan Ki Hajar Dewantara No. 1 Summarecon Serpong - Tangerang 15810</h5> -->
<table>
    <thead>
        <th> </th>
        <th> <img src="{{ public_path('/img/pahoa.png') }}" width="100" height="100"> </th>
        <th  colspan='10' style="font-weight: bold;  vertical-align: center; font-size: 14px;" > Rekap Data Berobat Siswa </th>
    </thead>
</table>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>NIY</th>
        <th>Nama</th>
        <th>Jenjang</th>
        <th>Kelas</th>
        <th>Diagnosis Umum</th>
        <th>Tanggal Mulai Periksa</th>
        <th>Tanggal Selesai Periksa</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 0;?>
    @foreach($Treatment as $treatment)
    <?php $no++ ;?>
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $treatment->niy }}</td>
            <td>{{ $treatment->name }}</td>
            <td>{{ $treatment->level }}</td>
            <td>{{ $treatment->kelas }}</td>
            <td>@foreach($treatment->studenttreatmentgeneraldiagnosis as $t)
                {{ $t->generaldiagnosis->diagnosis_name }}<br>
                @endforeach</td>            
	    <td>{{ date('d-m-Y', strtotime( $treatment->inspection_date)) }}</td>
            <td>{{ date('d-m-Y', strtotime( $treatment->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>