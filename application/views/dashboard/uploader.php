<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$sql = "SELECT s.kodestatus,count(p.status) as jml FROM status s 
        LEFT JOIN pengajuan p ON (s.kodestatus=p.status AND p.uname=".$this->db->escape($this->session->userdata('user')['uname']).") 
		GROUP BY s.kodestatus";
$res = $this->db->query($sql);
$pengajuan = [];
while ($row = $res->unbuffered_row('array')) {
	$pengajuan[$row['kodestatus']] = $row;
}

$sql = "SELECT nip,nama,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data 
		FROM pns
		WHERE nip=".$this->db->escape($this->session->userdata('user')['uname'])."
        ";
$res = $this->db->query($sql);
$prow = $res->unbuffered_row('array');
$prow['data'] = json_decode($prow['data'],true);
foreach($prow['data'] as $key => $val) {
	if (substr($key,0,3)=='tmt' && strlen($val)==5) $prow['data'][$key] = gmdate("d-m-Y", ($val - 25569) * 86400);
	else if (substr($key,0,3)=='tgl' && strlen($val)==5) $prow['data'][$key] = gmdate("d-m-Y", ($val - 25569) * 86400);
}
		
?>

<div class="row">
	<div class="col col-md-6 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-blue"><i class="fas fa-user"></i></span>
		  <div class="info-box-content">
			<span class="info-box-number"><?=$prow['nip']?></span>
			<span class="info-box-text"><?=$prow['nama']?></span>
			<span class="info-box-text"><?=$prow['data']['kdpangkat']?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-6 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-yellow"><i class="fas fa-home"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text"><?=$prow['data']['nmskpd']?></span>
			<span class="info-box-text"><?=$prow['data']['nmsatker']?></span>
			<span class="info-box-text"><i>Tgl Data: <?=$prow['data']['tmtberlaku']?></i></span>
		  </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-green"><i class="fas fa-file-alt"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">TMT SK</span>
			<span class="info-box-number"><?=$prow['data']['tmtskmt']?></span>
		  </div>
		</div>
	</div>	
	<div class="col col-md-3 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-green"><i class="fas fa-upload"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">TMT KGB</span>
			<span class="info-box-number"><?=$prow['data']['tmtkgb']?></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-3 col-sm-12">
		<div class="info-box <?=strtotime($prow['data']['tmtkgbyad'])>time()?"bg-green":"bg-red"?>">
		  <span class="info-box-icon bg-white"><i class="fas fa-file-excel"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">TMT KGBYAD</span>
			<span class="info-box-number"><?=$prow['data']['tmtkgbyad']?></span>
		  </div>
		</div>
	</div>

</div>
<hr>
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