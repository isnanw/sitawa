 <?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <section id="content" class="content">
      <div class="content__header content__boxed overlapping">
				<div class="content__wrap">
          <h1 class="page-title mb-0 mt-2"><i class="fas fa-user"></i><?= $detailpegawai['pegawai']; ?></h1>
            <div class="callout callout-info">
              <h5> <?= $detailpegawai['nip']; ?></h5>

            </div>
				</div>
			</div>
			<div class="content__boxed">
				<div class="content__wrap">
 					<div class="card">
						<div class="card-body">
						<div class="row">
							<div class="col-12">
							<!-- <div class="card"> -->
								<!-- <div class="card-header">
								<h3 class="card-title">Data Dokumen</h3>
								</div> -->
								<!-- /.card-header -->
								<!-- <div class="card-body "> -->
									<input class="btn btn-primary" type="button" value="<< Kembali" onclick="history.back(-1)" />
									<hr>
								<table id="tblData" class="table table-bordered table-striped">
									<thead>
									<tr>
									<th>Jenis Dokumen</th>
									<th>Tanggal</th>
									<th>Uraian</th>
									<th>Berkas</th>
									</tr>
									</thead>
									<tbody>
								</table>
								<!-- </div> -->
								<!-- /.card-body -->
							<!-- </div> -->
							<!-- /.card -->
							</div>
						</div>
				</div>
    <!-- </div> -->
    </div>
  </section>

<?=$previewmodal;?>

  <script language="javascript">

	function view(id) {
		if (id!='') {
			$("#modal-preview").find("#imgpreview").attr('src','<?=base_url('index.php/'.$this->router->class.'/preview/');?>'+id);
			$('#modal-preview').modal('show');
		}
	}

	$(function () {
		$("#tblData").DataTable({
		  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false,
		  "ajax":
        {
          "url":"<?=base_url($this->router->class.'/list');?>",
          "type": "POST",
          'data': {
                    id: "<?= $this->uri->segment(3) ?>"
                  }
        },

		  "columns": [
				{ "data": "kodeberkas" },
				{ "data": "tanggal" },
				{ "data": "uraian" },
				{ "data": "namafile" }
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

		$('#tanggal').datetimepicker({
			format: 'YYYY-MM-DD'
		});
	  });
  </script>

