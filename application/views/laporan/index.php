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
										<h3 class="card-title">Laporan Pegawai</h3>
										</div>
										<!-- /.card-header -->
										<div class="card-body ">
										<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#statusmodal">
  												Status Kepegawaian
										</button>
										<!-- <button type="button" class="btn btn-sm btn-success laporan" data-jenis="belumkgb" >Pegawai Belum KGB</button>
										<button type="button" class="btn btn-sm btn-success laporan" data-jenis="kgbbulanini" >Pegawai KGB Bulan ini</button>
										<button type="button" class="btn btn-sm btn-success laporan" data-jenis="58tahun" >Pegawai Usia 58-59 Tahun</button>
										<button type="button" class="btn btn-sm btn-success laporan" data-jenis="60tahun" >Pegawai Usia 60-64 Tahun</button>
										<button type="button" class="btn btn-sm btn-success laporan" data-jenis="65tahun" >Pegawai Usia 65 Tahun atau lebih</button> -->

										<hr>
										<table id="tblData" class="table table-bordered table-striped">
											<thead>
											<tr>
										    <th>NIP</th>
											<th>Nama</th>
											<th>Tanggal Lahir</th>
											<th>Jenis Kelamin</th>
											<th>Jabatan</th>
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

<!-- Modal -->
<div class="modal fade" id="statusmodal" tabindex="-1" aria-labelledby="statusmodallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusmodallabel">Cetak Per Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?= base_url('Laporan/cetak') ?>">
      <div class="modal-body">
		  <div class="mb-3">
		    <label for="filter" class="form-label">Status Kepegawaian</label>
		    <select id="filter" name="filter" class="form-control">
		    	<option value="0">---Semua---</option>
		    	<option value="1">PNS</option>
		    	<option value="2">CPNS</option>
		    	<option value="3">HONORER</option>
		    </select>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Cetak</button>
        <!-- <a href="<?= base_url('Laporan/cetak?filter=1') ?>" name="cetak" class="btn btn-danger btn-col-1" target="_blank" role="button" aria-disabled="true"><i class="fa fa-balance-scale fa-fw"></i>Cetak</a> -->
      </div>
      </form>
    </div>
  </div>
</div>

  <script language="javascript">
	$(function () {
		var table = $("#tblData").DataTable({
		  // "dom": 'lfBrtipB',
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": false,  "ordering": false,
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/listdetail');?>", "type": "POST"},
		  "columns": [
				{ "data": "nip" },
				{ "data": "nama" },
				{ "data": "tgl_lahir" },
				{ "data": "jenis_kelamin" },
				{ "data": "jabatan_pekerjaan" },
				{ "data": "detail" }
			],
		});
		table.buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');
	});
  </script>