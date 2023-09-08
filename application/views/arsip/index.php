<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-12">
	<div class="card">
	  <div class="card-header">
		<h3 class="card-title">Data Arsip Pengajuan Dokumen</h3>
	  </div>
	  <!-- /.card-header -->
	  <div class="card-body ">
		<table id="tblData" class="table table-bordered table-striped">
		  <thead>
		  <tr>
			<th>NIP</th>
			<th>Nama</th>
			<th>Keterangan</th>
			<th>Waktu</th>			
			<th>Dokumen</th>
			<th>Tracking</th>
			<th>Aksi</th>
		  </tr>
		  </thead>
		  <tbody>
		</table>
	  </div>
	  <!-- /.card-body -->
	</div>
	<!-- /.card -->
  </div>
</div>
 
 <div class="modal fade" id="modal-tracking">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Tracking</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">        
			<div id="qrcode"></div>           
		</div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal --> 
 
  <script language="javascript">	
	var qrcode = null;
	
	function tracking(id) {
		if (id!='') {
			qrcode.clear(); 
			qrcode.makeCode("<?=base_url('index.php/tracking/?kode=');?>"+id);
			$('#modal-tracking').modal('show');
		}
	}
  
	function selesai(id) {
	  if (confirm("Yakin akan menyelesaikan data?")) {
		  $.ajax( {
		  url: '<?=base_url('index.php/'.$this->router->class.'/selesai/');?>'+id,
		  type: 'GET',
		  success: function(data){
			  var json = $.parseJSON(data);
			  if (json.status=="ok") {
				toastr.success(json.msg);
				$('#tblData').DataTable().ajax.reload();
			  } else toastr.error(json.msg);
			}
		  });
	  }
	}
  
	$(function () {			
		qrcode = new QRCode("qrcode");	
		$("#tblData").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false, 
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "nip" },
				{ "data": "nama" },
				{ "data": "keterangan" },
				{ "data": "tanggal" },				
				{ "data": "dokumen" },
				{ "data": "kodetracking" },
				{ "data": "aksi" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');			  
		
	});	  
  </script>