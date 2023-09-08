<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$sql = "SELECT s.kodestatus,count(p.status) as jml FROM status s LEFT JOIN pengajuan p ON (s.kodestatus=p.status) GROUP BY s.kodestatus";
$res = $this->db->query($sql);
$pengajuan = [];
while ($row = $res->unbuffered_row('array')) {
	$pengajuan[$row['kodestatus']] = $row;
}

$sql = "select data->>'nmskpd' as skpd,count(1) as jml_peg,
sum(s0) as s0,sum(s1) as s1,sum(s2) as s2,sum(s3) as s3,sum(s4) as s4,sum(s5) as s5,
sum(case when to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)<now() then 1 else 0 end) as kgbyad, 
sum(case when to_char(to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400),'YYYY-MM')=to_char(now(),'YYYY-MM')  then 1 else 0 end) as kgbyad_bln
from (
	select convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data,
    (select count(1) from pengajuan where uname=p.nip and status=0) as s0,
    (select count(1) from pengajuan where uname=p.nip and status=1) as s1,
    (select count(1) from pengajuan where uname=p.nip and status=2) as s2,
    (select count(1) from pengajuan where uname=p.nip and status=3) as s3,
    (select count(1) from pengajuan where uname=p.nip and status=4) as s4,
    (select count(1) from pengajuan where uname=p.nip and status=5) as s5
    from pns p 
) a
group by data->>'nmskpd'
order by data->>'nmskpd'
";
$res = $this->db->query($sql);
$skpd = [];
while ($row = $res->unbuffered_row('array')) {
	$skpd[] = $row;
}


?>

<div class="row">
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-blue"><i class="fas fa-file-alt"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Draft Pengajuan</span>
			<span class="info-box-number"><?=number_format($pengajuan[0]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-yellow"><i class="fas fa-clipboard-check"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Pengajuan Terkirim</span>
			<span class="info-box-number"><?=number_format($pengajuan[1]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-red"><i class="fas fa-check-double"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Dokumen Kurang</span>
			<span class="info-box-number"><?=number_format($pengajuan[2]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>	
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-green"><i class="fas fa-check-double"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Dokumen Lengkap</span>
			<span class="info-box-number"><?=number_format($pengajuan[3]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-3 col-sm-12">
		<div class="info-box bg-red">
		  <span class="info-box-icon bg-white"><i class="fas fa-archive"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Arsip Dibatalkan</span>
			<span class="info-box-number"><?=number_format($pengajuan[4]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-3 col-sm-12">
		<div class="info-box bg-green">
		  <span class="info-box-icon bg-white"><i class="fas fa-archive"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">Arsip Selesai</span>
			<span class="info-box-number"><?=number_format($pengajuan[5]['jml'],0,',','.')?></span>
		  </div>
		</div>
	</div>	
</div>
<hr>
<div class="row">
	<div class="col">
		<table class="table table-bordered">
		  <thead>
			<tr>
			  <th style="width: 10px">#</th>
			  <th>SKPD</th>
			  <th>Jml Peg</th>
			  <th>Draft</th>
			  <th>Pengajuan</th>
			  <th>Dok Kurang</th>
			  <th>Dok Lengkap</th>
			  <th>Dibatalkan</th>
			  <th>Selesai</th>
			  <th>KGBYAD sd bulan ini</th>
			  <th>KGBYAD bulan ini</th>
			</tr>
		  </thead>
		  <tbody>
<?php 
$i=1;
foreach($skpd as $row) {
	echo  "<tr>
			  <td>".$i++."</td>
			  <td>".$row['skpd']."</td>
			  <td>".$row['jml_peg']."</td>
			  <td>".$row['s0']."</td>
			  <td>".$row['s1']."</td>
			  <td>".$row['s2']."</td>
			  <td>".$row['s3']."</td>
			  <td>".$row['s4']."</td>
			  <td>".$row['s5']."</td>
			  <td>".$row['kgbyad']."</td>
			  <td>".$row['kgbyad_bln']."</td>
			</tr>";
}
?>
		  </tbody>
		</table>
	</div>
</div>