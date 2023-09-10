<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datapns extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('tgl_indo');

		$this->load->model('M_laporan');
	}

	public function index()
	{
		if (@sizeof($this->session->userdata('user')) < 1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');
		// if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/mainku/dashboard', 'refresh');

		$data = [
			'judul'			=> 'Data Pegawai',
			'diskripsi' => '<hr>'
		];

		$this->template->render_page('datapns/index', $data, TRUE);

		// $data = [];

		// $content = $this->load->view('datapns', $data, TRUE);

		// $this->load->view('main',['content'=>$content]);
	}

	//fungsi-fungsi AJAX
	public function list()
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) die();

		$search = "";

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length > 0) $filter = " LIMIT " . $length . " OFFSET " . $start;
		else $filter = "";

		$sts = $this->input->post('filter');
		if (!empty($sts)) {
			if ($sts == 0) {
				$search = "";
			} elseif ($sts == 1) {
				$search = "WHERE convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb ->> 'status_kepegawaian' = 'PNS' ";
			} elseif ($sts == 2) {
				$search = "WHERE convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb ->> 'status_kepegawaian' = 'CPNS' ";
			} elseif ($sts == 3) {
				$search = "WHERE convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb ->> 'status_kepegawaian' = 'Honorer' ";
			}
		}

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns " . $search . " ORDER BY nip " . $filter;

		// die($sts);

		$sql = "SELECT * FROM (" . $sql . ") TBLDATA ";
		if (isset($_POST['search']['value'])) $sql .= "WHERE LOWER(nama) like '%" . $this->db->escape_str($this->input->post("search")['value']) . "%'";

		// $search = '';
		// if ($this->input->post("search")['value'] != '') $sql .= "WHERE LOWER(nama) like '%" . $this->db->escape_str($this->input->post("search")['value']) . "%' ";

		$xsqlx = "SELECT * FROM pns " . $search . " ";
		$totaldata = $this->db->query($xsqlx)->num_rows();

		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$json = json_decode($row["data"], true);
			$row['skpd'] = $json['nmskpd'];
			$row['pegawai'] = $json['status_kepegawaian'];
			$row['detail'] = "<button class=\"btn btn-sm btn-success\" onClick=\"detail('" . $row["nip"] . "')\"><i class=\"fa fa-id-card\"></i></button>
			<a href=\"" . base_url('datapns/ubah?nip=') . $row["nip"] . "\" class=\"btn btn-sm btn-warning\"><i class=\"fa fa-edit\"></i> </a>
			<button class=\"btn btn-sm btn-danger\" onClick=\"del('" . $row["nip"] . "')\"><i class=\"fa fa-trash-alt\"></i></button>";
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null ? [] : $data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}

	public function tambah()
	{
		if (@sizeof($this->session->userdata('user')) < 1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');

		$data = [
			'judul'			=> 'Tambah Data Pegawai',
			'diskripsi' => '<hr>'
		];

		$this->template->render_page('datapns/tambah', $data, TRUE);
	}

	public function tambahData()
	{
		if (@sizeof($this->session->userdata('user')) < 1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');

		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');

		$data = array(
			''	=> null,
			'nip' 	=> $this->input->post('nip'),
			'nama'	=> $this->input->post('nama'),
			'agama'	=> $this->input->post('agama'),
			'ruang'	=> $this->input->post('ruang'),
			'nmskpd'	=> $this->input->post('opd'),
			'alamat'	=> $this->input->post('alamat'),
			'status'	=> 'Aktif',
			'tgl_lahir'	=> shortdate_indo($this->input->post('tgllahir')),
			'pendidikan'	=> $this->input->post('pendidikan'),
			'tempat_lahir'	=> $this->input->post('tempatlahir'),
			'jenis_kelamin'	=> $this->input->post('jeniskelamin'),
			'pangkat_golongan'	=> $this->input->post('pangkat'),
			'jabatan_pekerjaan'	=> $this->input->post('jabatan'),
			// 'jenis_kepegawaian'	=> 1,
			'status_kepegawaian'	=> $this->input->post('statuspegawai'),
			'tmt_pangkat_golongan' => shortdate_indo($this->input->post('tmt_pangkat_golongan')),
			'tmt_jabatan_pekerjaan'	=> shortdate_indo($this->input->post('tmt_jabatan_pekerjaan'))
		);

		try {

			$json = json_encode($data);
			$sql = "INSERT INTO pns(nip,nama,data,status) VALUES(
					" . $this->db->escape($nip) . ",
					" . $this->db->escape($nama) . ",
					encrypt('" . pg_escape_bytea($json) . "'," . $this->db->escape($nip) . ",'aes'),
					1
					)";
			// $result = $this->db->query($sql)->row_array();
			// die($sql);
			$this->db->query($sql);
			$result = ["status" => "ok", "msg" => "Sukses Tambah"];
		} catch (Exception $e) {
			$result = ["status" => "error", "msg" => "Gagal Tambah"];
		}

		echo json_encode($result);
	}

	public function ubah()
	{
		if (@sizeof($this->session->userdata('user')) < 1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');
		if (sizeof($this->session->userdata('user')) < 1) die();
		// $id = urldecode($nip);
		$nip = $this->input->get('nip');

		$data = [
			'judul'			=> 'Ubah Data Pegawai',
			'diskripsi' => '<hr>',
			'list'				=> $this->M_laporan->readdetail($nip)
		];

		$this->template->render_page('datapns/ubah', $data, TRUE);
	}

	public function ubahData()
	{
		if (@sizeof($this->session->userdata('user')) < 1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');

		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');

		$data = array(
			''	=> null,
			'nip' 	=> $this->input->post('nip'),
			'nama'	=> $this->input->post('nama'),
			'agama'	=> $this->input->post('agama'),
			'ruang'	=> $this->input->post('ruang'),
			'nmskpd'	=> $this->input->post('opd'),
			'alamat'	=> $this->input->post('alamat'),
			'status'	=> 'Aktif',
			'tgl_lahir'	=> shortdate_indo($this->input->post('tgllahir')),
			'pendidikan'	=> $this->input->post('pendidikan'),
			'tempat_lahir'	=> $this->input->post('tempatlahir'),
			'jenis_kelamin'	=> $this->input->post('jeniskelamin'),
			'pangkat_golongan'	=> $this->input->post('pangkat'),
			'jabatan_pekerjaan'	=> $this->input->post('jabatan'),
			// 'jenis_kepegawaian'	=> 1,
			'status_kepegawaian'	=> $this->input->post('statuspegawai'),
			'tmt_pangkat_golongan' => shortdate_indo($this->input->post('tmt_pangkat_golongan')),
			'tmt_jabatan_pekerjaan'	=> shortdate_indo($this->input->post('tmt_jabatan_pekerjaan'))
		);

		try {

			$json = json_encode($data);
			$sql = "UPDATE pns
							SET nip = " . $this->db->escape($nip) . ",
									nama = " . $this->db->escape($nama) . ",
									data = encrypt('" . pg_escape_bytea($json) . "'," . $this->db->escape($nip) . ",'aes'),
									status = 1
							WHERE nip = " . $this->db->escape($nip) . "
					";
			// $result = $this->db->query($sql)->row_array();
			// die($sql);
			$this->db->query($sql);
			$result = ["status" => "ok", "msg" => "Sukses Ubah Data"];
		} catch (Exception $e) {
			$result = ["status" => "error", "msg" => "Gagal Ubah Data"];
		}

		echo json_encode($result);
	}


	public function get($id)
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		$id = urldecode($id);

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns WHERE nip=" . $this->db->escape($id) . " ";
		$result = $this->db->query($sql)->row_array();
		echo json_encode($result);
	}

	public function hapus($id)
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		// if ($this->session->userdata('user')['role']!='MAINTAINER') die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) die();
		$id = urldecode($id);

		try {
			$sql = "DELETE FROM pns WHERE nip=" . $this->db->escape($id) . " ";
			$res = $this->db->query($sql);

			$result = ["status" => "ok", "msg" => "Sukses Hapus"];
		} catch (Exception $e) {
			$result = ["status" => "error", "msg" => "Gagal Hapus"];
		}

		echo json_encode($result);
	}
}
