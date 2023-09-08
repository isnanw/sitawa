<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenisdok extends CI_Controller {

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/main/dashboard', 'refresh');
		$data = [
			'judul'			=> 'Jenis Dokumen',
			'diskripsi' => '<hr>'
		];

		$this->template->render_page('jenisdok', $data, TRUE);

		// $content = $this->load->view('jenisdok', $data, TRUE);
		// $this->load->view('main',['content'=>$content]);
	}

	//fungsi-fungsi AJAX
	public function list()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length>0) $filter = " LIMIT ".$length." OFFSET ".$start;
		else $filter="";

		$search = '';
		if ($this->input->post("search")['value']!='') $search = "WHERE keterangan like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT * FROM jenisdok ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT *,kodeberkas as id FROM jenisdok ".$search." ORDER BY kodeberkas ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$sql = "SELECT coalesce(count(1),0) as jml FROM dms WHERE is_delete != true AND kodeberkas=".$this->db->escape($row["id"]);
			$result = $this->db->query($sql)->row_array();
			if ($result['jml']>0) {
				$row['aksi'] = "<button class=\"btn btn-sm btn-success\">Terpakai</button>";
			} else {
				$row['aksi'] = "<button class=\"btn btn-sm btn-warning\" onClick=\"edit('".$row["id"]."')\"><i class=\"fa fa-edit\"></i></button>
								<button class=\"btn btn-sm btn-danger\" onClick=\"del('".$row["id"]."')\"><i class=\"fa fa-trash-alt\"></i></button>";
			}
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}

	public function tambah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();

		try {
			$sql = "INSERT INTO jenisdok(kodeberkas,keterangan,ext) VALUES(
					".$this->db->escape($this->input->post('kode')).",
					".$this->db->escape($this->input->post('keterangan')).",
					".$this->db->escape($this->input->post('ext')).")";
			$res = $this->db->query($sql);
			$result = ["status"=>"ok", "msg"=> "Sukses Tambah"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Tambah"];
		}

		echo json_encode($result);
	}

	public function get($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();
		$id = urldecode($id);

		$sql = "SELECT *,kodeberkas as id FROM jenisdok WHERE kodeberkas=".$this->db->escape($id)." ";
		$result = $this->db->query($sql)->row_array();
		echo json_encode($result);
	}

	public function ubah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();

		try {
			$sql = "UPDATE jenisdok SET
					kodeberkas=".$this->db->escape($this->input->post('kode')).",
					keterangan=".$this->db->escape($this->input->post('keterangan')).",
					ext=".$this->db->escape($this->input->post('ext'))."
					WHERE kodeberkas=".$this->db->escape($this->input->post('id'))."";
			$res = $this->db->query($sql);
			$result = ["status"=>"ok", "msg"=> "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Edit"];
		}

		echo json_encode($result);
	}

	public function hapus($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();
		$id = urldecode($id);

		try {
			$sql = "DELETE FROM jenisdok WHERE kodeberkas=".$this->db->escape($id)." ";
			$res = $this->db->query($sql);

			$result = ["status"=>"ok", "msg"=> "Sukses Hapus"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Hapus"];
		}

		echo json_encode($result);
	}

}
