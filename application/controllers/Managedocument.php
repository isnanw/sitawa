<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageDocument extends CI_Controller {
  public function __construct()
    {
        parent::__construct();
        if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		    if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');

        $this->user = $this->db->get_where('pengguna', ['uname' => $this->session->userdata('uname')])->row_array();

        $this->load->model('M_ManageDocument', 'mmd');
				$this->load->model('M_Pns', 'mpns');
				$this->load->model('M_Cpns', 'mcpns');
				$this->load->model('M_Honorer', 'mhonorer');
    }

	public function index()
	{
		$sql = "SELECT * FROM jenisdok ORDER BY kodeberkas";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$data['jenisdok'][] = $row;
		}

		$data = [
            'judul' => 'Data Dokumen Per Status Kepegawaian',
						'diskripsi' => '<hr>',
            'jumlahpegawai' => $this->mmd->countPegawai(),
						'jumlahcpns' => $this->mmd->countCPNS(),
						'jumlahpns' => $this->mmd->countPNS(),
						'jumlahhonorer' => $this->mmd->countHonorer(),
        ];

		$this->template->render_page('managedocument/pegawai', $data, TRUE);
	}

	public function pegawai()
	{
		$sql = "SELECT * FROM jenisdok ORDER BY kodeberkas";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$data['jenisdok'][] = $row;
		}

		$data = [
            'judul' => 'Data Dokumen Per Pegawai',
						'diskripsi' => '<hr>',
        ];

		$this->template->render_page('managedocument/index', $data, TRUE);
	}

	public function pns()
	{
		$sql = "SELECT * FROM jenisdok ORDER BY kodeberkas";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$data['jenisdok'][] = $row;
		}

		$data = [
            'judul' => 'Data Dokumen Per Pegawai PNS',
						'diskripsi' => '<hr>',
        ];

		$this->template->render_page('managedocument/pns', $data, TRUE);
	}

	public function cpns()
	{
		$sql = "SELECT * FROM jenisdok ORDER BY kodeberkas";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$data['jenisdok'][] = $row;
		}

		$data = [
            'judul' => 'Data Dokumen Per Pegawai CPNS',
						'diskripsi' => '<hr>',
        ];

		$this->template->render_page('managedocument/cpns', $data, TRUE);
	}

	public function honorer()
	{
		$sql = "SELECT * FROM jenisdok ORDER BY kodeberkas";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$data['jenisdok'][] = $row;
		}

		$data = [
            'judul' => 'Data Dokumen Per Pegawai PNS',
						'diskripsi' => '<hr>',
        ];

		$this->template->render_page('managedocument/honorer', $data, TRUE);
	}

  public function detail($id)
    {

        $data = [
            'judul' => 'Manajemen Dokumen',
						'jenisdok' => $this->mmd->jenisdok(),
            'detailpegawai' => $this->mmd->getDMS($id),
						'previewmodal' => $this->load->view('previewmodal', null, TRUE)
        ];
				// die($this->db->last_query());
        // $content = $this->load->view('managedocument/detail', $data, TRUE);

				// $data['previewmodal'] = $this->load->view('previewmodal', null, TRUE);

		    // $this->load->view('main',['content'=>$content]);
				$this->template->render_page('managedocument/detail', $data, TRUE);
    }

    public function detaildoklaporan($id)
    {

        $data = [
            'judul' => 'Manajemen Dokumen',
						'jenisdok' => $this->mmd->jenisdok(),
            'detailpegawai' => $this->mmd->getDMS($id),
						'previewmodal' => $this->load->view('previewmodal', null, TRUE)
        ];
				// die($this->db->last_query());
        // $content = $this->load->view('managedocument/detail', $data, TRUE);

				// $data['previewmodal'] = $this->load->view('previewmodal', null, TRUE);

		    // $this->load->view('main',['content'=>$content]);
				$this->template->render_page('managedocument/detaildoklaporan', $data, TRUE);
    }

  public function ambilData()
    {
        if ($this->input->is_ajax_request() == true) {
            $list = $this->mmd->get_datatables();
            $data = [];
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = [];

                // tombol aksi
                $btnAction = "<a href='" . base_url('') . "managedocument/detail/$field->nip' class='btn btn-info btn-block btn-flat'> Manage </a>";

                // isi
                $row[] = $field->nip;
                $row[] = $field->pegawai;
                $row[] = $field->jumlah;
                $row[] = $btnAction;

                $data[] = $row;
            }

            $output = [
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mmd->count_all(),
                "recordsFiltered" => $this->mmd->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }

		 public function ambilDataPns()
    {
        if ($this->input->is_ajax_request() == true) {
            $list = $this->mpns->get_datatables();
            $data = [];
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = [];

                // tombol aksi
                $btnAction = "<a href='" . base_url('') . "managedocument/detail/$field->nip' class='btn btn-info btn-block btn-flat'> Manage </a>";

                // isi
                $row[] = $field->nip;
                $row[] = $field->pegawai;
                $row[] = $field->jumlah;
                $row[] = $btnAction;

                $data[] = $row;
            }

            $output = [
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mmd->count_all(),
                "recordsFiltered" => $this->mmd->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }

		public function ambilDataCpns()
    {
        if ($this->input->is_ajax_request() == true) {
            $list = $this->mcpns->get_datatables();
            $data = [];
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = [];

                // tombol aksi
                $btnAction = "<a href='" . base_url('') . "managedocument/detail/$field->nip' class='btn btn-info btn-block btn-flat'> Manage </a>";

                // isi
                $row[] = $field->nip;
                $row[] = $field->pegawai;
                $row[] = $field->jumlah;
                $row[] = $btnAction;

                $data[] = $row;
            }

            $output = [
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mmd->count_all(),
                "recordsFiltered" => $this->mmd->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }

		public function ambilDataHonorer()
    {
        if ($this->input->is_ajax_request() == true) {
            $list = $this->mhonorer->get_datatables();
            $data = [];
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = [];

                // tombol aksi
                $btnAction = "<a href='" . base_url('') . "managedocument/detail/$field->nip' class='btn btn-info btn-block btn-flat'> Manage </a>";

                // isi
                $row[] = $field->nip;
                $row[] = $field->pegawai;
                $row[] = $field->jumlah;
                $row[] = $btnAction;

                $data[] = $row;
            }

            $output = [
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mmd->count_all(),
                "recordsFiltered" => $this->mmd->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }


	//fungsi-fungsi AJAX
	public function list()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length>0) $filter = " LIMIT ".$length." OFFSET ".$start;
		else $filter="";

		$id = $_POST['id'];
		// $id = "196711291996101001";
		// die($id);

		// $cekstatus = $_GET['status'];

		// var_dump($cekstatus);

		$search = '';
		if ($this->input->post("search")['value']!='') $search = "AND LOWER(uraian) like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT * FROM dms WHERE is_delete != 'true' AND uname='".$id."' ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();
		// die($sql);
		$sql = "SELECT * FROM dms WHERE is_delete != 'true' AND uname='".$id."' ".$search." ORDER BY tanggal DESC ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$row['namafile'] = '<button class="btn btn-sm btn-success" onClick="view('.$row['id'].')"><i class="fa fa-eye"></i></button> Filesize: '.number_format($row['size']/(1024*1024),2)." MB";

			$sql = "SELECT coalesce(count(1),0) as jml FROM pengajuan_detail WHERE id_dms=".$this->db->escape($row['id']);
			$result = $this->db->query($sql)->row_array();

			if ($result['jml']>0) {
					$row['aksi'] = "<button class=\"btn btn-sm btn-success\">Terpakai</button>";
			} else {
					$row['aksi'] = '<button class="btn btn-sm btn-warning" onClick="edit('.$row['id'].')"><i class="fa fa-edit"></i></button>
				<button class="btn btn-sm btn-danger" onClick="del('.$row['id'].')"><i class="fa fa-trash-alt"></i></button>';
			}
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		ini_set('memory_limit', '128M');
		echo json_encode($result);
	}

	public function tambah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();

		$id = $_POST['id'];

		$sql = "SELECT * FROM jenisdok WHERE kodeberkas=".$this->db->escape($this->input->post('kodeberkas'))." ";
		$res = $this->db->query($sql)->row_array();

		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = str_replace(",","|",str_replace(["."," "],"",$res['ext']));
		$config['encrypt_name'] = true;
		$config['max_size']     = '2048';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('berkas')) {
			$file = $this->upload->data();
			if (!empty($this->input->post("tgl_dokumen")))
			{
				$sql = "INSERT INTO dms(uname,kodeberkas,uraian,mime,size,data,no_dokumen,tanggal_dokumen,created) VALUES(
			        '".$id."',
			        ".$this->db->escape($this->input->post('kodeberkas')).",
							".$this->db->escape($this->input->post('uraian')).",
							".$this->db->escape(mime_content_type($config['upload_path'].$file['file_name'])).",
							".$this->db->escape(filesize($config['upload_path'].$file['file_name'])).",
							encrypt('".pg_escape_bytea(file_get_contents($config['upload_path'].$file['file_name']))."','".$id."','aes'),
							".$this->db->escape($this->input->post('no_dokumen')).",
							".$this->db->escape($this->input->post('tgl_dokumen')).",
							".$this->db->escape($this->session->userdata('user')['uname']).")";
				}
				else {
					$sql = "INSERT INTO dms(uname,kodeberkas,uraian,mime,size,data,no_dokumen,created) VALUES(
			        '".$id."',
			        ".$this->db->escape($this->input->post('kodeberkas')).",
							".$this->db->escape($this->input->post('uraian')).",
							".$this->db->escape(mime_content_type($config['upload_path'].$file['file_name'])).",
							".$this->db->escape(filesize($config['upload_path'].$file['file_name'])).",
							encrypt('".pg_escape_bytea(file_get_contents($config['upload_path'].$file['file_name']))."','".$id."','aes'),
							".$this->db->escape($this->input->post('no_dokumen')).",
							".$this->db->escape($this->session->userdata('user')['uname']).")";
				}
				// die($sql);
				$res = $this->db->query($sql);
			if ($res) $result = ["status"=>"ok", "msg"=> "Sukses Upload"];
			else $result = ["status"=>"error", "msg"=> "Gagal Upload"];

			unlink($config['upload_path'].$file['file_name']);
		} else {
			$result = ["status"=>"error", "msg"=> "Gagal Upload ".$this->upload->display_errors()];
		}
		echo json_encode($result);
	}

	public function get($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();

		$id = (int) $id;
		$uname = $_GET['uname'];
		$sql = "SELECT id,uname,kodeberkas,uraian,tanggal,no_dokumen,tanggal_dokumen FROM dms WHERE uname='".$uname."' AND id=".$this->db->escape($id)." ";
		$result = $this->db->query($sql)->row_array();

		$sql = "SELECT * FROM jenisdok WHERE kodeberkas=".$this->db->escape($result['kodeberkas'])." ";
		$dok = $this->db->query($sql)->row_array();
		$result['keterangan'] = $dok['keterangan'];
		$result['ext'] = $dok['ext'];

		echo json_encode($result);
	}

	public function getlist($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();
		$id = urldecode($id);

		$sql = "SELECT id,uraian as text,tanggal FROM dms WHERE uname='".$id."' AND kodeberkas=".$this->db->escape($id)." ";
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$row['text'] .=  ' [ Diupload '.date('d-m-Y H:i:s',strtotime($row['tanggal'])).' ]';
			$data[] = $row;
		}

		echo json_encode(["results"=>$data]);
	}

	public function preview($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		$uname = "";
		if ($this->session->userdata('user')['role']=='UPLOADER') $uname = " uname='".$id."' AND ";

		$id = (int) $id;
		$sql = "SELECT mime,decrypt(data,uname::bytea,'aes') as data FROM dms
		        WHERE ".$uname." id=".$this->db->escape($id)." ";
		$result = $this->db->query($sql)->row_array();
		header("content-type: ".$result['mime']);
		echo pg_unescape_bytea($result['data']);
	}

	public function ubah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();
		$id = $_POST['uname'];

		$sql = "SELECT * FROM jenisdok WHERE kodeberkas=".$this->db->escape($this->input->post('kodeberkas'))." ";
		$res = $this->db->query($sql)->row_array();

		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = str_replace(",","|",str_replace(["."," "],"",$res['ext']));
		$config['encrypt_name'] = true;
		$config['max_size']     = '2048';
		$this->load->library('upload', $config);

		try {

			// if ($this->input->post('uraian')!='') {
			// 	$sql = "UPDATE dms SET
			// 			uraian=".$this->db->escape($this->input->post('uraian'))."
			// 			WHERE uname='".$id."' AND id=".$this->db->escape($this->input->post('id'))."";
			// 	$res = $this->db->query($sql);
			// }
			if($this->upload->do_upload('berkas')) {
				$file = $this->upload->data();
				$sql = "UPDATE dms SET
						uraian=".$this->db->escape($this->input->post('uraian')).",
						mime=".$this->db->escape(mime_content_type($config['upload_path'].$file['file_name'])).",
						size=".$this->db->escape(filesize($config['upload_path'].$file['file_name'])).",
						data=encrypt('".pg_escape_bytea(file_get_contents($config['upload_path'].$file['file_name']))."','".$id."','aes')
						WHERE uname='".$id."' AND id=".$this->db->escape($this->input->post('id'))."";
				$res = $this->db->query($sql);

				unlink($config['upload_path'].$file['file_name']);
			}

			if ($res) $result = ["status"=>"ok", "msg"=> "Sukses Upload"];
				else $result = ["status"=>"error", "msg"=> "Gagal Upload".$this->upload->display_errors()];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Edit ".$this->upload->display_errors()];
		}

		echo json_encode($result);
	}

	public function hapus($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();
		$uname = $_GET['uname'];
		$id = (int) $id;

		// Maaf saya nonaktifkan dulu
		// try {
		// 	$sql = "DELETE FROM dms WHERE uname='".$uname."' AND id=".$this->db->escape($id)." ";
		// 	$res = $this->db->query($sql);

		// 	$result = ["status"=>"ok", "msg"=> "Sukses Hapus"];
		// } catch (Exception $e) {
		// 	$result = ["status"=>"error", "msg"=> "Gagal Hapus"];
		// }

		// Diganti Update
		try {
			$sql = "UPDATE dms SET is_delete = TRUE WHERE uname='".$uname."' AND id=".$this->db->escape($id)." ";
			$res = $this->db->query($sql);

			$result = ["status"=>"ok", "msg"=> "Sukses Hapus"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Hapus"];
		}

		echo json_encode($result);
	}

}
