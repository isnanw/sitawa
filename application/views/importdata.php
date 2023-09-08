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
								<div class="row">
									<div class="col-12">
									<div class="card">
										<div class="card-header">
										<h3 class="card-title">Import Data</h3>
										</div>
										<!-- /.card-header -->
										<div class="card-body ">
										<button id="import" type="button" class="btn btn-success"><i class="nav-icon fas fa-upload"></i> Import Data </button> <hr>
										<table id="tblData" class="table table-bordered table-striped">
											<thead>
											<tr>
											<th>Tanggal</th>
											<th>Jumlah Row</th>
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
							</div>
					</div>
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
	    <form id="upload">
			<div class="modal-header">
				<h4 class="modal-title">Import Data </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<div class="form-group">
						<!-- File Input -->
							<div class="row mb-12">
								<label for="berkas" class="col-sm-3 col-form-label">Berkas XLS</label>
								<div class="col-sm-9">
										<input id="berkas" name="berkas" type="file" accept=".xls" class="form-control" type="file">
										<small style="color: red;"> Format file yang di upload : Microsoft Excel 97-2003 Worksheet (<b>.xls</b>)</small>
								</div>
							</div>
							<hr>
							<div class="row mb-12">
								<label for="berkas" class="col-sm-3 col-form-label">Contoh Berkas XLS</label>
								<div class="col-sm-9">
										<a href="<?= base_url('templateExcel.xls')?>" type="button" class="btn btn-warning">Download Contoh Format File XLS</a>
										<br>
										<small style="color: red;"> Note : Pada saat mengisi tanggal di excel dibuat string (tanggal/bulan/tahun). Misal <b>'25/12/2022</b></small>
								</div>
							</div>
								<!-- END : File Input -->
						</div>
				</div>
				<!-- /.card-body -->
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btn-tambah">Simpan</button>
			</div>
			</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <script language="javascript">
		$("#import").click(function () {
			$('#modal-add').modal('show');
		});
	$(function () {
		$("#tblData").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false,
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "tanggal" },
				{ "data": "jumlah" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

		$('#tanggal').datetimepicker({
			format: 'YYYY-MM-DD'
		});

		$('#upload' )
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url($this->router->class.'/doimport');?>',
			  type: 'POST',
			  data: new FormData( this ),
			  processData: false,
			  contentType: false,
				// data: $(this).serialize(),
				beforeSend: function() {
						$("#btn-tambah").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>')
				},
				complete: function() {
						$("#btn-tambah").html('Tambah Data')
				},
			  success: function(data){
				var json = $.parseJSON(data);
				if (json.status=="ok") {
					toastr.success(json.msg);
					$('#upload').trigger("reset");
					$('#modal-add').modal('hide');
					$('#tblData').DataTable().ajax.reload();
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });

	  });
  </script>