<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-12">
	<div class="card">
	  <div class="card-header">
		<h3 class="card-title">Data Hotline</h3>
	  </div>
	  <!-- /.card-header -->
	  <div class="card-body ">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="nav-icon fas fa-plus"></i> Tambah</button> <hr>
		<table id="tblDataHotline" class="table table-bordered table-striped">
		  <thead>
		  <tr>
			<th>No</th>
			<th>Urai</th>
			<th>Link</th>
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
		  <h4 class="modal-title">Tambah</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="card-body">
        <div class="form-group">
				<label for="icon">Icon Hotline</label>
				<input name="icon" type="text" class="form-control" id="icon" placeholder="fa fa-phone" required>
			  </div>
			  <div class="form-group">
				<label for="urai">Urai Hotline</label>
				<input name="urai" type="text" class="form-control" id="urai" placeholder="Urai Hotline" required>
			  </div>
			  <div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
			  </div>
			  <div class="form-group">
				<label for="link">Link</label>
				<input name="link" type="text" class="form-control" id="link" placeholder="https://contoh.com" required>
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
		  <h4 class="modal-title">Edit</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="card-body">
			  <div class="form-group">
					<label for="urai">Icon</label>
					<input name="icon" type="hidden">
					<!-- <input name="id" type="text" class="form-control" id="id" placeholder="id"> -->
					<input name="icon" type="text" class="form-control" id="icon" placeholder="fa fa-phone">
			  </div>
				<!-- <label for="id">id Jenis Dokumen</label> -->
				<input name="id" type="hidden" class="form-control" id="id" placeholder="id">
				<div class="form-group">
					<label for="urai">Urai</label>
					<input name="id" type="hidden">
					<input name="urai" type="text" class="form-control" id="urai" placeholder="urai">
			  </div>
			  <div class="form-group">
					<label for="keterangan">Keterangan</label>
					<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
			  </div>
			  <div class="form-group">
					<label for="link">Link</label>
					<input name="link" type="text" class="form-control" id="link" placeholder="Link">
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
				$('#tblDataHotline').DataTable().ajax.reload();
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
			$("#edit").find("input[name=icon]").val(json.icon);
		  $("#edit").find("input[name=urai]").val(json.urai);
		  $("#edit").find("textarea[name=keterangan]").val(json.keterangan);
		  $("#edit").find("input[name=link]").val(json.link);
		  $('#modal-edit').modal('show');

		}
	  });
	}

	$(function () {
		$("#tblDataHotline").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false,
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "id" },
				{ "data": "keterangan" },
				{ "data": "link" },
				{ "data": "aksi" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblDataHotline_wrapper .col-md-6:eq(0)');


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
					$('#tblDataHotline').DataTable().ajax.reload();
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
					$('#tblDataHotline').DataTable().ajax.reload();
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });

	  });
  </script>