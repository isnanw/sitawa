<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasikgb extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->helper('tgl_indo');

				$this->load->model('M_laporan');
    }

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) redirect('/mainku/dashboard', 'refresh');
		// if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/mainku/dashboard', 'refresh');

		$data = [
			'judul'			=> 'Data Pegawai ',
			'diskripsi' => ' Kenaikan Gaji Berkala (KGB)'
		];

		$this->template->render_page('notifikasi/kgb', $data, TRUE);
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

		$search = '';
		if ($this->input->post("search")['value']!='') $search = "WHERE LOWER(nama) like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT * FROM pns ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns ".$search." ORDER BY nip ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
      $json = json_decode($row["data"],true);
      if($row['tgl_kgb'] <> ''){
        $tgl = mediumdate_indonesia($row['tgl_kgb']);
				$reset = "<button title=\"Reset Tanggal\" class=\"btn btn-sm btn-warning\" onClick=\"reset('".$json["nip"]."')\"><i class=\"fa fa-calendar-times\"></i></button>";
      }else{
        $tgl = 'Belum Dijadwalkan';
				$reset = "";
      }
			$row['skpd'] = $json['jabatan_pekerjaan'];
			$row['pegawai'] = $tgl;
			$row['detail'] = "<button title=\"Set Tanggal\" class=\"btn btn-sm btn-success\" onClick=\"edit('".$json["nip"]."')\"><i class=\"fa fa-cogs\"></i></button> ".$reset." ";
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}

  public function get($id)
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		$id = urldecode($id);

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns WHERE nip=".$this->db->escape($id)." ";
		$result = $this->db->query($sql)->row_array();
		echo json_encode($result);
	}

  public function ubah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();

		try {
			$sql = "UPDATE pns SET
					nip=".$this->db->escape($this->input->post('nip')).",
					nama=".$this->db->escape($this->input->post('nama')).",
					tgl_kgb=".$this->db->escape($this->input->post('tgl_kgb'))."
					WHERE nip=".$this->db->escape($this->input->post('nip'))."";
			$res = $this->db->query($sql);
			$result = ["status"=>"ok", "msg"=> "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Edit"];
		}

		echo json_encode($result);
	}

	public function reset()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER'])) die();

		try {
			$sql = "UPDATE pns SET
					tgl_kgb = Null
					WHERE nip=".$this->db->escape($this->input->post('nip'))."";
			$res = $this->db->query($sql);
			$result = ["status"=>"ok", "msg"=> "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Edit"];
		}

		echo json_encode($result);
	}

}