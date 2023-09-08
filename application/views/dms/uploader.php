<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-12">
	<div class="card">
	  <div class="card-header">
		<h3 class="card-title">Data Dokumen</h3>
	  </div>
	  <!-- /.card-header -->
	  <div class="card-body ">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="nav-icon fas fa-plus"></i> Tambah</button> <hr>	  
		<table id="tblData" class="table table-bordered table-striped">
		  <thead>
		  <tr>
			<th>Tanggal</th>
			<th>Judul</th>
			<th>Deskripsi</th>
			<th>Berkas</th>
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

  <div class="modal fade" id="modal-add">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="tambah">
		<div class="modal-header">
		  <h4 class="modal-title">Tambah Berkas</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">        
			<div class="card-body">
			  <div class="form-group">
				<label for="judul">Judul</label>
				<input name="judul" type="text" class="form-control" id="judul" placeholder="Judul">
			  </div>
			  <div class="form-group">
				<label for="deskripsi">Deskripsi</label>
				<textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi"></textarea>
			  </div>
			  <div class="form-group">
			    <label>Tanggal</label>
				  <div class="input-group date" id="tanggal" data-target-input="nearest">
					<input name="tanggal" type="text" class="form-control datetimepicker-input" data-target="#tanggal" data-toggle="datetimepicker"/>
					<div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				  </div>
			    </div>			  
			  <div class="form-group">
				<label for="berkas">Berkas</label>
				<div class="input-group">
				  <div class="custom-file">
					<input name="berkas" type="file" accept=".jpg,.png,.pdf" class="custom-file-input" id="berkas">
					<label class="custom-file-label" for="berkas">Pilih file</label>
				  </div>
				  <div class="input-group-append">
					<span class="input-group-text">Upload</span>
				  </div>
				</div>
			  </div>
			</div>
			<!-- /.card-body -->              
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		   <button type="submit" class="btn btn-primary">Simpan</button>
		</div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
  <div class="modal fade" id="modal-edit">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="edit">
		<div class="modal-header">
		  <h4 class="modal-title">Edit Berkas</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">        
			<div class="card-body">
			  <div class="form-group">
				<label for="judul">Judul *</label>
				<input name="id" type="hidden">
				<input name="judul" type="text" class="form-control" id="judul" placeholder="Judul">
			  </div>
			  <div class="form-group">
				<label for="deskripsi">Deskripsi *</label>
				<textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi"></textarea>
			  </div>
			  <div class="form-group">
			    <label>Tanggal *</label>
				  <div class="input-group date" id="tanggal" data-target-input="nearest">
					<input name="tanggal" type="text" class="form-control datetimepicker-input" data-target="#tanggal" data-toggle="datetimepicker"/>
					<div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				  </div>
			    </div>			  
			  <div class="form-group">
				<label for="berkas">Berkas</label>
				<div class="input-group">
				  <div class="custom-file">
					<input name="berkas" type="file" accept=".jpg,.png,.pdf" class="custom-file-input" id="berkas">
					<label class="custom-file-label" for="berkas">Pilih file</label>
				  </div>
				  <div class="input-group-append">
					<span class="input-group-text">Upload</span>
				  </div>
				</div>
				<small>Berkas hanya untuk upload ulang dan menimpa berkas yang telah ada, lewati jika tidak ingin menimpa berkas</small>
			  </div>
			</div>
			<!-- /.card-body -->              
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		   <button type="submit" class="btn btn-primary">Simpan</button>
		</div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->  
  <script language="javascript">	
	function del(id) {
	  if (confirm("Yakin akan menghapus data?")) {
		  $.ajax( {
		  url: '<?=base_url('index.php/'.$this->router->class.'/hapus/');?>'+id,
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
	function edit(id) {
	  $.ajax( {
	  url: '<?=base_url('index.php/'.$this->router->class.'/get/');?>'+id,
	  type: 'GET',
	  success: function(data){
		  var json = $.parseJSON(data);
		  $("#edit").find("input[name=id]").val(json.id);
		  $("#edit").find("input[name=judul]").val(json.judul);
		  $("#edit").find("textarea[name=deskripsi]").val(json.deskripsi);
		  $("#edit").find("input[name=tanggal]").val(json.tanggal);
		  $('#modal-edit').modal('show');
		  
		}
	  });
	}
	
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
				{ "data": "aksi" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');
	
		$('#tanggal').datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$('#tambah' )
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url('index.php/'.$this->router->class.'/tambah');?>',
			  type: 'POST',
			  data: new FormData( this ),
			  processData: false,
			  contentType: false,
			  success: function(data){
				var json = $.parseJSON(data);
				if (json.status=="ok") {
					toastr.success(json.msg);
					$('#tambah').trigger("reset");
					$('#modal-add').modal('hide');
					$('#tblData').DataTable().ajax.reload();
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });	
		  
		$('#edit' )
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url('index.php/'.$this->router->class.'/ubah');?>',
			  type: 'POST',
			  data: new FormData( this ),
			  processData: false,
			  contentType: false,
			  success: function(data){
				var json = $.parseJSON(data);
				if (json.status=="ok") {
					toastr.success(json.msg);
					$('#edit').trigger("reset");
					$('#modal-edit').modal('hide');
					$('#tblData').DataTable().ajax.reload();
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });	  
		
	  });	  
  </script>