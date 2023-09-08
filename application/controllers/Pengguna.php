<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/main/dashboard', 'refresh');
		$data = [
			'judul'			=> 'Data Pengguna',
			'diskripsi' => '<hr>'
		];

		// $content = $this->load->view('pengguna', $data, TRUE);
		$this->template->render_page('pengguna', $data, TRUE);

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
		if ($this->input->post("search")['value']!='') $search = "WHERE uname like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT * FROM pengguna ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT *,uname as id FROM pengguna ".$search." ORDER BY uname ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$row['aksi'] = "<button class=\"btn btn-sm btn-warning\" onClick=\"edit('".$row["id"]."')\"><i class=\"fa fa-edit\"></i></button>
							<button class=\"btn btn-sm btn-danger\" onClick=\"del('".$row["id"]."')\"><i class=\"fa fa-trash-alt\"></i></button>";
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
			$sql = "INSERT INTO pengguna(uname,nama,pass,role) VALUES(
					".$this->db->escape($this->input->post('uname')).",
					".$this->db->escape($this->input->post('nama')).",
					crypt(".$this->db->escape($this->input->post('pass')).", gen_salt('md5')),
					".$this->db->escape($this->input->post('role')).")";
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

		$sql = "SELECT uname as id,nama,role FROM pengguna WHERE uname=".$this->db->escape($id)." ";
		$result = $this->db->query($sql)->row_array();
		echo json_encode($result);
	}

	public function ubah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();

		try {
			$pass = "";
			if ($this->input->post('pass')!='') {
				$pass = "pass = crypt(".$this->db->escape($this->input->post('pass')).", gen_salt('md5')),";
			}
			$sql = "UPDATE pengguna SET
					nama=".$this->db->escape($this->input->post('nama')).",
					".$pass."
					role=".$this->db->escape($this->input->post('role'))."
					WHERE uname=".$this->db->escape($this->input->post('id'))."";
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
			$sql = "DELETE FROM pengguna WHERE uname=".$this->db->escape($id)." ";
			$res = $this->db->query($sql);

			$result = ["status"=>"ok", "msg"=> "Sukses Hapus"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Hapus"];
		}

		echo json_encode($result);
	}

}
