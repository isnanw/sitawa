<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('M_Upload');

    }

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');

		$data = [
			'judul'			=> 'Data Profil',
			'diskripsi' => '<hr>'
		];

		// $content = $this->load->view('pengguna', $data, TRUE);
		$this->template->render_page('profil', $data, TRUE);
	}

	//fungsi-fungsi AJAX
	public function get()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		$sql = "SELECT A.uname as id,
									A.nama,
									A.role,
									B.nik,
									B.npwp
						FROM vusers A LEFT JOIN pengguna B ON (A.uname = B.uname) WHERE A.uname=".$this->db->escape($this->session->userdata('user')['uname'])." ";
		// var_dump($sql);
		// die();
		$result = $this->db->query($sql)->row_array();
		echo json_encode($result);
	}

	public function upload(){
		 	$data = [
			'judul'			=> 'Upload Foto',
			'diskripsi' => '<hr>',
			// 'detail' => $this->db->get_where('upload',['id' => $uname])->row()
		];
		$this->template->render_page('profil/upload', $data, TRUE);
	}

	public function upload_aksi(){
			$id = $this->input->post('id');
			// $upload_img = $_FILES['photo_home']['name'];

			if($_FILES['photo_home']['name'] !="" ){

				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '2048';

				$this->load->library('upload', $config);

				if (! $this->upload->do_upload('photo_home')) {
						$error = array('error' => $this->upload->display_errors());
				} else {
						$upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
				}
		}
		$data=array('gambar'=>$image_name);
		$this->M_Upload->db_update($data,$id);
		redirect(base_url('profil'));
	}


	public function ubah()
	{
		if (sizeof($this->session->userdata('user'))<1) die();

		try {
			if ($this->session->userdata('user')['role']=='UPLOADER') {
				$sql = "SELECT * FROM pengguna WHERE uname=".$this->db->escape($this->session->userdata('user')['uname'])." ";
				$res = $this->db->query($sql)->row_array();
				if ($res==0) {
					$sql = "INSERT INTO pengguna(uname,nama,nik,npwp,pass,role) VALUES(
					".$this->db->escape($this->session->userdata('user')['uname']).",
					".$this->db->escape($this->session->userdata('user')['nama']).",
					".$this->db->escape($this->session->userdata('user')['nik']).",
					".$this->db->escape($this->session->userdata('user')['npwp']).",
					crypt('dmspapua', gen_salt('md5')),
					".$this->db->escape($this->session->userdata('user')['role']).")";
					$res = $this->db->query($sql);
				}
			}

			$pass = "";
			if ($this->input->post('pass')!='') {
				$pass = "pass = crypt(".$this->db->escape($this->input->post('pass')).", gen_salt('md5')),";
			}
			$sql = "UPDATE pengguna SET
					".$pass."
					nama=".$this->db->escape($this->input->post('nama')).",
					nik=".$this->db->escape($this->input->post('nik')).",
					npwp=".$this->db->escape($this->input->post('npwp'))."
					WHERE uname=".$this->db->escape($this->session->userdata('user')['uname'])."";
			$res = $this->db->query($sql);
			$result = ["status"=>"ok", "msg"=> "Sukses Edit"];
			if ($pass!='') $result = ["status"=>"relogin", "msg"=> "Sukses Edit"];
		} catch (Exception $e) {
			$result = ["status"=>"error", "msg"=> "Gagal Edit"];
		}

		echo json_encode($result);
	}

}
