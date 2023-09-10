<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
	.close {
		color: black;
		float: right;
		font-size: 30px;
		/* color: #fff; */
	}

	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
</style>
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
									<div class="row">
										<div class="col-md-3">
											<label for="filter"><b>Filter</b></label>
											<select id="filter" name="filter" class="form-control">
												<option value="0">---Semua---</option>
												<option value="1">PNS</option>
												<option value="2">CPNS</option>
												<option value="3">HONORER</option>
											</select>
											<br>
											<button type="button" id="btn-filter" class="btn btn-success"><i class="nav-icon fas fa-check"></i>Filter</button>
										</div>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body ">
									<table id="tblData" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>NIP</th>
												<th>Nama</th>
												<th>Jabatan</th>
												<th>Tanggal KGB</th>
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
				</div>
			</div>
		</div>
	</div>
	<!-- FOOTER -->
	<footer class="mt-auto">
		<div class="content__boxed">
			<div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
				<div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#" class="ms-1 btn-link fw-bold">SITAWA Kab Mimika</a></div>
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

<div class="modal fade" id="modal-edit">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="edit">
				<div class="modal-header">
					<h4 class="modal-title">Edit</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<label for="nip">NIP</label>
							<input name="nip" type="text" class="form-control" id="nip" placeholder="nip" readonly>
						</div>
						<br>
						<div class="form-group">
							<label for="nama">Nama Pegawai</label>
							<input name="nama" type="text" class="form-control" id="nama" placeholder="nama" readonly>
						</div>
						<br>
						<div class="form-group">
							<label for="tgl_kgb">Tanggal KGB</label>
							<input name="tgl_kgb" type="date" class="form-control" id="tgl_kgb">
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

<div class="modal fade" id="modal-reset">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form id="reset">
				<div class="modal-header">
					<h4 class="modal-title">Apakah Anda Ingin Mereset Tanggal KGB ?</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<label for="nip">NIP</label>
							<input name="nip" type="text" class="form-control" id="nip" placeholder="nip" readonly>
						</div>
						<br>
						<div class="form-group">
							<label for="nama">Nama Pegawai</label>
							<input name="nama" type="text" class="form-control" id="nama" placeholder="nama" readonly>
						</div>
						<br>
						<!-- <div class="form-group">
					<label for="tgl_kgb">Tanggal KGB</label>
					<input name="tgl_kgb_reset" type="date" class="form-control" id="tgl_kgb_reset" >
					</div> -->
					</div>
					<!-- /.card-body -->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Proses</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>



<script language="javascript">
	tblDetail = null;
	var tblData;

	function edit(nip) {
		$.ajax({
			url: '<?= base_url($this->router->class . '/get/'); ?>' + nip,
			type: 'GET',
			success: function(data) {
				var json = $.parseJSON(data);
				$("#edit").find("input[name=nip]").val(json.nip);
				$("#edit").find("input[name=nama]").val(json.nama);
				$("#edit").find("input[name=tgl_kgb]").val(json.tgl_kgb);
				$('#modal-edit').modal('show');

			}
		});
	}

	function reset(nip) {
		$.ajax({
			url: '<?= base_url($this->router->class . '/get/'); ?>' + nip,
			type: 'GET',
			success: function(data) {
				var json = $.parseJSON(data);
				$("#reset").find("input[name=nip]").val(json.nip);
				$("#reset").find("input[name=nama]").val(json.nama);
				$('#modal-reset').modal('show');

			}
		});
	}



	$(function() {
		tblDetail = $("#tblDetail").DataTable({
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"responsive": true,
			"lengthChange": true,
			"autoWidth": false,
			"paging": true,
			"columns": [{
					"data": "attr"
				},
				{
					"data": "data"
				},
			],
		});

		tblData = $("#tblData").DataTable({
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"responsive": true,
			"lengthChange": true,
			"autoWidth": false,
			"paging": true,
			"processing": true,
			"serverSide": true,
			"ordering": false,
			"ajax": {
				"url": "<?= base_url($this->router->class . '/list'); ?>",
				"type": "POST",
				"data": function(data) {
					data.filter = $('#filter').val();
				}
			},
			"columns": [{
					"data": "nip"
				},
				{
					"data": "nama"
				},
				{
					"data": "skpd"
				},
				{
					"data": "pegawai"
				},
				{
					"data": "detail"
				},
			],
			"buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

		$('#btn-filter').click(function() {
			$('#tblData').DataTable().ajax.reload();
		});

		$('#edit')
			.submit(function(e) {
				$.ajax({
					url: '<?= base_url($this->router->class . '/ubah'); ?>',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function(data) {
						var json = $.parseJSON(data);
						if (json.status == "ok") {
							toastr.success(json.msg);
							$('#edit').trigger("reset");
							$('#modal-edit').modal('hide');
							$('#tblData').DataTable().ajax.reload();
						} else toastr.error(json.msg);
					}
				});
				e.preventDefault();
			});

		$('#reset')
			.submit(function(e) {
				$.ajax({
					url: '<?= base_url($this->router->class . '/reset'); ?>',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function(data) {
						var json = $.parseJSON(data);
						if (json.status == "ok") {
							toastr.success(json.msg);
							$('#reset').trigger("reset");
							$('#modal-reset').modal('hide');
							$('#tblData').DataTable().ajax.reload();
						} else toastr.error(json.msg);
					}
				});
				e.preventDefault();
			});

	});
</script>