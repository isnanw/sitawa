<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-12">
	<div class="card">
	  <div class="card-header">
		<h3 class="card-title">View Pengajuan Dokumen</h3>
	  </div>
	  <!-- /.card-header -->
	  <div class="card-body ">
		<form id="frm">
		  <div class="form-group">
			<label for="tanggal">Tanggal Pengajuan</label>
			<input name="tanggal" type="text" class="form-control" id="tanggal" placeholder="Tanggal" readonly="readonly" value="<?= $data['tglpengajuan'];?>">
		  </div>		
		  <div class="form-group">
			<label for="judul">Form Pengajuan</label>
			<input name="judul" type="text" class="form-control" id="judul" placeholder="Form Pengajuan" readonly="readonly" value="<?= $formpengajuan['judul'];?>">
		  </div>
		  <div class="form-group">
			<label for="keterangan">Keterangan</label>
			<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan" readonly="readonly"><?= $formpengajuan['keterangan'];?></textarea>
		  </div>
		  <div class="form-group">
			<label>Pegawai</label>
			<div class="input-group">
				<div class="input-group-prepend">
				  <span class="input-group-text"><?= $data['nip'];?></span>
				</div>			
				<input name="nama" type="text" class="form-control" readonly="readonly" value="<?= $data['nama'];?>">
				<div class="input-group-append"><button type="button" class="btn btn-sm btn-success viewpns"><i class="nav-icon fas fa-user"></i> Lihat</button></div>
			</div>
		  </div>
		  <div class="form-group">
			<label for="skpd">SKPD</label>
			<input name="skpd" type="text" class="form-control" readonly="readonly" value="<?= $data['data']['nmskpd'];?>">			
		  </div>
		  <div class="form-group">
			<label >TMT</label>
			<div class="row">
				<div class="input-group col-3 mb-3">
				  <div class="input-group-prepend">
					<span class="input-group-text">Data</span>
				  </div>
				  <input type="text" class="form-control"  readonly="readonly" value="<?= @$data['data']['tmtberlaku'];?>">
				</div>			
				<div class="input-group col-3 mb-3">
				  <div class="input-group-prepend">
					<span class="input-group-text">SK</span>
				  </div>
				  <input type="text" class="form-control"  readonly="readonly" value="<?= @$data['data']['tmtskmt'];?>">
				</div>
				<div class="input-group col-3 mb-3">
				  <div class="input-group-prepend">
					<span class="input-group-text">KGB</span>
				  </div>
				  <input type="text" class="form-control"  readonly="readonly" value="<?= @$data['data']['tmtkgb'];?>">
				</div>
				<div class="input-group col-3 mb-3">
				  <div class="input-group-prepend">
					<span class="input-group-text">KGB+1</span>
				  </div>
				  <input type="text" class="form-control"  readonly="readonly" value="<?= @$data['data']['tmtkgbyad'];?>">
				</div>				
			</div>
		  </div>	  
		  <div class="form-group">
			<label for="catatan">Catatan</label>
			<textarea name="catatan" class="form-control" id="catatan" readonly="readonly" placeholder="Catatan" ><?= $data['catatan'];?></textarea><br>
		  </div>		  
		  <hr>
		  <label >Dokumen Terlampir:</label>
		  <div id="frmdok">
		  <?php
			foreach($formpengajuan['dokumen'] as $val) {
				echo '<div class="form-group">'.
					'  <label>'.$val['uraian'].'</label>'.
					'  <div class="input-group">'.
					'    <input name="dokumen['.$val['kodeformdetail'].']" class="form-control" data-id="'.$val['id_dms'].'" data-placeholder="Pilih Dokumen" value="'.$val['text'].'" readonly="readonly">'.
					'    <div class="input-group-append"><button type="button" class="btn btn-sm btn-success viewdok"><i class="nav-icon fas fa-eye"></i> Lihat</button></div>'.
					'  </div>'.
					'</div>';			
				
			}
		  ?>		  
		  </div>
		  <div class="form-group">
			<a href="<?=base_url('index.php/'.$this->router->class.'');?>"><button type="button" class="btn btn-default">Kembali</button></a>
		  </div>
		</form>
	  </div>
	  <!-- /.card-body -->
	</div>
	<!-- /.card -->
  </div>
</div> 

<?=$previewmodal;?>

  <div class="modal fade" id="modal-detail">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="detail">
		<div class="modal-header">
		  <h4 class="modal-title">Detail</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">        
			<div class="card-body">	
			  <div class="form-group">
				  <table id="tblDetail" class="table table-bordered table-striped">
				  <thead>
				  <tr>
					<th>Atribut</th>
					<th>Data</th>
				  </tr>
				  </thead>
				  <tbody>
<?php foreach($data['data'] as $key => $val) echo "<tr><td>".$key."</td><td>".$val."</td></tr>"; ?>
				  </tbody>
				</table>					
			  </div>
			</div>
			<!-- /.card-body -->              
		</div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <script language="javascript">	
	$(function () {					
		$('.viewpns').off('click').on('click',function() {
		  $('#modal-detail').modal('show');
		});						
		
		$('.viewdok').off('click').on('click',function() {
			let dok = $(this).parent().parent().find('input[name^=dokumen]').data('id');
			if (dok!='') {
				$("#modal-preview").find("#imgpreview").attr('src','<?=base_url('index.php/dms/preview/');?>'+dok);
				$('#modal-preview').modal('show');
			}
		});			
				
	});	  
  </script>