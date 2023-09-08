<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<section id="content" class="content">
		<div class="content__header content__boxed overlapping">
			<div class="content__wrap">
				<h1 class="page-title mb-0 mt-2"><?= $judul; ?></h1>
					<p class="lead">
							<?= $diskripsi; ?>
					</p>
			</div>
		</div>

			<div class="content__boxed">
					<div class="content__wrap">
							<!-- Table with toolbar -->
							<div class="card">
									<div class="card-header -4 mb-3">
											<!-- <h5 class="card-title mb-3">Table with toolbar</h5> -->
											<div class="row">

													<!-- Left toolbar -->
													<div class="col-md-6 d-flex gap-1 align-items-center mb-3">
															<!-- <button class="btn btn-primary hstack gap-2 align-self-center">
																	<i class="demo-psi-add fs-5"></i>
																	<span class="vr"></span>
																	Tambah Data
															</button> -->
															<button type="button" class="btn btn-primary hstack gap-2 align-self-center" id="tambahjenisdok"><i class="nav-icon fas fa-plus"></i> Tambah</button> <hr>
													</div>
													<!-- END : Left toolbar -->

											</div>
									</div>

									<div class="card-body">
											<div class="table-responsove">
												<table id="tblData" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th>Kode Jenis Dokumen</th>
															<th>Keterangan</th>
															<th>Extension</th>
															<th>Aksi</th>
														</tr>
													</thead>
												</table>
											</div>
									</div>
							</div>
							<!-- END : Table with toolbar -->

					</div>
			</div>
			<!-- FOOTER -->
			<footer class="mt-auto">
					<div class="content__boxed">
							<div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
									<div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#" class="ms-1 btn-link fw-bold">SIDKD Kab Mimika</a></div>
									<nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto" style="row-gap: 0 !important;">
											<!-- <a class="nav-link px-0" href="#">Policy Privacy</a>
											<a class="nav-link px-0" href="#">Terms and conditions</a>
											<a class="nav-link px-0" href="#">Contact Us</a> -->
									</nav>
							</div>
					</div>
			</footer>
			<!-- END - FOOTER -->

	</section>

  <div class="modal fade" id="modal-add">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="tambah">
		<div class="modal-header">
		  <h4 class="modal-title">Tambah</h4>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="card-body">
			  <div class="form-group">
				<label for="kode">Kode Jenis Dokumen</label>
				<input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" required>
			  </div>
			  <div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
			  </div>
			  <div class="form-group">
				<label for="ext">Extension</label>
				<input name="ext" type="text" class="form-control" id="ext" placeholder=".jpg,.png,.pdf" required>
			  </div>
			</div>
			<!-- /.card-body -->
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="card-body">
			  <div class="form-group">
				<label for="kode">Kode Jenis Dokumen</label>
				<input name="id" type="hidden">
				<input name="kode" type="text" class="form-control" id="kode" placeholder="Kode">
			  </div>
			  <div class="form-group">
				<label for="keterangan">Keterangan</label>
				<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
			  </div>
			  <div class="form-group">
				<label for="ext">Extension</label>
				<input name="ext" type="text" class="form-control" id="ext" placeholder=".jpg,.png,.pdf">
			  </div>
			</div>
			<!-- /.card-body -->
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
		$("#tambahjenisdok").click(function () {
			$('#modal-add').modal('show');
		});
	function del(id) {
	  if (confirm("Yakin akan menghapus data?")) {
		  $.ajax( {
		  url: '<?=base_url($this->router->class.'/hapus/');?>'+id,
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
	  url: '<?=base_url($this->router->class.'/get/');?>'+id,
	  type: 'GET',
	  success: function(data){
		  var json = $.parseJSON(data);
		  $("#edit").find("input[name=id]").val(json.id);
		  $("#edit").find("input[name=kode]").val(json.id);
		  $("#edit").find("textarea[name=keterangan]").val(json.keterangan);
		  $("#edit").find("input[name=ext]").val(json.ext);
		  $('#modal-edit').modal('show');

		}
	  });
	}

	$(function () {
		$("#tblData").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false,
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "id" },
				{ "data": "keterangan" },
				{ "data": "ext" },
				{ "data": "aksi" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');


		$('#tambah' )
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url($this->router->class.'/tambah');?>',
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