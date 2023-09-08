<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-12">
	<div class="card">
	  <div class="card-header">
		<h3 class="card-title">Data Arsip</h3>
	  </div>
	  <!-- /.card-header -->
	  <div class="card-body ">  
		<table id="tblData" class="table table-bordered table-striped">
		  <thead>
		  <tr>
			<th>Tanggal</th>
			<th>Judul</th>
			<th>Deskripsi</th>
			<th>Berkas</th>
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
<script language="javascript">	
	function view(id) {
	  window.open('<?=base_url('index.php/'.$this->router->class.'/preview/');?>'+id,'_blank');
	}	
		
	$(function () {			
		$("#tblData").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false, 
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "tanggal" },
				{ "data": "judul" },
				{ "data": "deskripsi" },
				{ "data": "namafile" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');
	});
</script>
