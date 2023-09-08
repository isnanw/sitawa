<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$sql = "SELECT max(to_timestamp(((data->>'tmtberlaku')::bigint - 25569) * 86400)) as lastupdate,count(1) as jml
		FROM (select convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data from pns) a";
$res = $this->db->query($sql);
$gaji = $res->unbuffered_row('array');

$sql = "SELECT max(postdate)as lastupdate,count(1) as jml from peg_presensi";
$res = $this->db->query($sql);
$presensi = $res->unbuffered_row('array');

$sql = "SELECT max(postdate)as lastupdate,count(1) as jml from peg_sapk";
$res = $this->db->query($sql);
$sapk = $res->unbuffered_row('array');

$sql = "SELECT max(postdate)as lastupdate,count(1) as jml from peg_dapodik";
$res = $this->db->query($sql);
$disdik = $res->unbuffered_row('array');


?>

<div class="row">
	<div class="col col-md-4 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-blue"><i class="fas fa-users"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">SIMGAJI</span>
			<span class="info-box-number"><?=number_format($gaji['jml'],0,',','.')?></span>
			<span class="info-box-text"><i>tgl data: <?=$gaji['lastupdate']?></i></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-4 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-yellow"><i class="fas fa-users"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">App Presensi</span>
			<span class="info-box-number"><?=number_format($presensi['jml'],0,',','.')?></span>
			<span class="info-box-text"><i>tgl data: <?=$presensi['lastupdate']?></i></span>
		  </div>
		</div>
	</div>
	<div class="col col-md-4 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-green"><i class="fas fa-users"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">SAPK</span>
			<span class="info-box-number"><?=number_format($sapk['jml'],0,',','.')?></span>
			<span class="info-box-text"><i>tgl data: <?=$sapk['lastupdate']?></i></span>
		  </div>
		</div>
	</div>	
	<div class="col col-md-4 col-sm-12">
		<div class="info-box">
		  <span class="info-box-icon bg-red"><i class="fas fa-users"></i></span>
		  <div class="info-box-content">
			<span class="info-box-text">App Disdik</span>
			<span class="info-box-number"><?=number_format($disdik['jml'],0,',','.')?></span>
			<span class="info-box-text"><i>tgl data: <?=$disdik['lastupdate']?></i></span>
		  </div>
		</div>
	</div>	
</div>
<hr>
