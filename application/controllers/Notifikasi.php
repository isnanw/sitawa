<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
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
			'judul'			=> 'Data Pegawai ',
			'diskripsi' => ' Yang Akan Naik Pangkat'
		];

		$this->template->render_page('notifikasi/index', $data, TRUE);
	}
	//fungsi-fungsi AJAX
	public function list()
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) die();

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

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns " . $search . " ORDER BY nip " . $filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$json = json_decode($row["data"], true);
			if ($row['tgl_kenaikan_pangkat'] <> '') {
				$tgl = mediumdate_indonesia($row['tgl_kenaikan_pangkat']);
				$reset = "<button title=\"Reset Tanggal\" class=\"btn btn-sm btn-warning\" onClick=\"reset('" . $json["nip"] . "')\"><i class=\"fa fa-calendar-times\"></i></button>";
			} else {
				$tgl = 'Belum Dijadwalkan';
				$reset = "";
			}
			$row['skpd'] = $json['jabatan_pekerjaan'];
			$row['pegawai'] = $tgl;
			$row['detail'] = "<button title=\"Set Tanggal\" class=\"btn btn-sm btn-success\" onClick=\"edit('" . $json["nip"] . "')\"><i class=\"fa fa-cogs\"></i></button> " . $reset . " ";
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null ? [] : $data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
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

	public function ubah()
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) die();

		try {
			$sql = "UPDATE pns SET
					nip=" . $this->db->escape($this->input->post('nip')) . ",
					nama=" . $this->db->escape($this->input->post('nama')) . ",
					tgl_kenaikan_pangkat=" . $this->db->escape($this->input->post('tgl_kenaikan_pangkat')) . "
					WHERE nip=" . $this->db->escape($this->input->post('nip')) . "";
			$res = $this->db->query($sql);
			$result = ["status" => "ok", "msg" => "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status" => "error", "msg" => "Gagal Edit"];
		}

		echo json_encode($result);
	}

	public function reset()
	{
		if (sizeof($this->session->userdata('user')) < 1) die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER'])) die();

		try {
			$sql = "UPDATE pns SET
					tgl_kenaikan_pangkat = Null
					WHERE nip=" . $this->db->escape($this->input->post('nip')) . "";
			$res = $this->db->query($sql);
			$result = ["status" => "ok", "msg" => "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status" => "error", "msg" => "Gagal Edit"];
		}

		echo json_encode($result);
	}
}
