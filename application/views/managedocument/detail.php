 <?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <section id="content" class="content">
      <div class="content__header content__boxed overlapping">
				<div class="content__wrap">
          <h1 class="page-title mb-0 mt-2"><i class="fas fa-user"></i><?= $detailpegawai['pegawai']; ?></h1>
            <div class="callout callout-info">
              <!-- <h4> <?= $detailpegawai['nip']; ?></h4> -->
							<hr>
 							<a type="button" href="<?= base_url('managedocument')?>" class="btn btn-danger"> Status Kepegawaian</a>
              <input class="btn btn-warning" type="button" value="Pegawai" onclick="history.back(-1)" />
							<a type="button" href="" class="btn btn-success"> Dokumen</a>
            </div><br>
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

									<button type="button" class="btn btn-primary" id="tambahberkas"><i class="nav-icon fas fa-plus"></i> Tambah</button>
									<hr>
								<table id="tblData" class="table table-bordered table-striped">
									<thead>
									<tr>
									<th>Jenis Dokumen</th>
									<th>Tanggal</th>
									<th>Uraian</th>
									<th>Berkas</th>
									<th>Aksi</th>
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

  <div class="modal fade" id="modal-add">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="tambah">
		<div class="modal-header">
		  <h4 class="modal-title">Tambah Berkas</h4>
		   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="card-body">
			  <div class="form-group">
        <div class="form-group">
					<!-- <label for="kodeberkas">Nomor Dokumen</label> -->
					<input type="hidden" name="id" id="id" class="form-control" value="<?= $this->uri->segment(3); ?>">
				</div>
				<label for="kodeberkas">Jenis Dokumen</label>
				<select name="kodeberkas" class="form-control" data-placeholder="Pilih Jenis Dokumen">
				<option value=''></option>
				<?php
				foreach($jenisdok as $row) {
					echo "<option value='".$row['kodeberkas']."' data-ext='".$row['ext']."' >".$row['kodeberkas']." - ".$row['keterangan']."</option>\n";
				}
				?>
				</select>
			  </div>
				<br>
				<!-- <div class="form-group">
					<label for="kodeberkas">Nomor Dokumen</label>
					<input type="text" name="no_dokumen" id="no_dokumen" class="form-control">
				</div>
				<br>
				<div class="form-group">
					<label for="kodeberkas">Tanggal Dokumen</label>
					<input type="date" name="tgl_dokumen" id="tgl_dokumen" class="form-control">
				</div> -->
				<br>
			  <div class="form-group">
				<label for="uraian">Uraian</label>
				<textarea name="uraian" class="form-control" id="uraian" placeholder="Uraian"></textarea>
			  </div>
				<br>
			  <div class="form-group">
				<label for="berkas">Berkas</label>
						<!-- END : File Input -->
				  <div class="custom-file">
					<input name="berkas" type="file" accept=".jpg" class="custom-file-input form-control" id="berkas">
					<!-- <label class="custom-file-label" for="berkas">Pilih file</label> -->
				  </div>
				<br>
				<small>*) Ukuran Data Maksimal <b>2 MB</b></small>
				<div><span style="color: red;" id="eror"></span></div>
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

  <div class="modal fade" id="modal-edit">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <form id="edit">
		<div class="modal-header">
		  <h4 class="modal-title">Edit Berkas</h4>
		   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="card-body">
			  <div class="form-group">
				<label for="kodeberkas">Jenis Dokumen</label>
				<input name="id" type="hidden">
				<input name="kodeberkas" type="hidden">
        <input name="uname" type="hidden">
				<input type="text" class="form-control" id="kodeberkas" placeholder="Jenis Dokumen" readonly="readonly">
			  </div>
				<!-- <div class="form-group">
					<label for="kodeberkas">Nomor Dokumen</label>
					<input type="text" name="no_dokumen" id="no_dokumen" class="form-control">
				</div>
				<div class="form-group">
					<label for="kodeberkas">Tanggal Dokumen</label>
					<input type="date" name="tgl_dokumen" id="tgl_dokumen" class="form-control">
				</div> --> <br>
			  <div class="form-group">
				<label for="uraian">Uraian *</label>
				<textarea name="uraian" class="form-control" id="uraian" placeholder="Uraian"></textarea>
			  </div>
				<br>
			  <div class="form-group">
				<label for="berkas">Berkas</label>
				<div class="input-group">
				  <div class="custom-file">
					<input name="berkas" type="file" accept=".jpg," class="custom-file-input form-control" id="berkas">
					<!-- <label class="custom-file-label" for="berkas">Pilih file</label> -->
				  </div>
				</div>
				<br>
				<small>Berkas hanya untuk upload ulang dan menimpa berkas yang telah ada, lewati jika tidak ingin menimpa berkas</small>

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


<?=$previewmodal;?>

  <script language="javascript">
		$("#tambahberkas").click(function () {
			$('#modal-add').modal('show');
		});
	function del(id) {
	  if (confirm("Yakin akan menghapus data?")) {
		  $.ajax( {
        url: '<?=base_url($this->router->class.'/hapus/');?>'+id,
        type: 'GET',
        data: {
            uname: "<?= $this->uri->segment(3) ?>"
          },
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
	  url: '<?=base_url($this->router->class.'/get/');?>'+id+'?uname=<?= $this->uri->segment(3) ?>',
	  type: 'GET',
	  success: function(data){
		  var json = $.parseJSON(data);
		  $("#edit").find("input[name=id]").val(json.id);
		  $("#edit").find("input[name=kodeberkas]").val(json.kodeberkas);
      $("#edit").find("input[name=uname]").val(json.uname);
		  $("#edit").find("input[id=kodeberkas]").val(json.kodeberkas+' - '+json.keterangan);
			$("#edit").find("input[name=no_dokumen]").val(json.no_dokumen);
			$("#edit").find("input[name=tgl_dokumen]").val(json.tanggal_dokumen);
		  $("#edit").find("textarea[name=uraian]").val(json.uraian);
		  $('#edit').find('input[name=berkas]').attr('accept',json.ext);
		  $('#edit').find('input[name=berkas]').val('').change();
		  $('#modal-edit').modal('show');

		}
	  });
	}

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
				{ "data": "namafile" },
				{ "data": "aksi" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

		$('#tanggal').datetimepicker({
			format: 'YYYY-MM-DD'
		});


		$('input[type=file]').on('change',function (){
			if ($(this).val()=='')
				$(this).parent().find('label').html('Pilih file');
			else
				$(this).parent().find('label').html($(this).val());
        });

		$('#tambah').find('select[name=kodeberkas]').select().on('change',function() {
			$('#tambah').find('input[name=berkas]').attr('accept',$(this).find(':selected').data('ext'));
		});

		$('#tambah' )
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url('index.php/'.$this->router->class.'/tambah');?>',
			  type: 'POST',
			  data: new FormData( this ),
			  processData: false,
			  contentType: false,
				beforeSend: function() {
						$("#btn-tambah").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>')
				},
				complete: function() {
						$("#btn-tambah").html('Tambah Data')
						$("#eror").html('Ukuran Berkas Terlalu Besar. Maksimal 2 MB')
				},
			  success: function(data){
				var json = $.parseJSON(data);
				if (json.status=="ok") {
					toastr.success(json.msg);
					$('#tambah').trigger("reset");
					$("#tambah").find("select[name^=kodeberkas").val([]).change();
					$('#tambah').find('input[name=berkas]').val('').change();
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
					$('#edit').find('input[name=berkas]').val('').change();
					$('#modal-edit').modal('hide');
					$('#tblData').DataTable().ajax.reload();
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });

	  });
  </script>

