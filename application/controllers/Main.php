<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))>1) redirect('/main/dashboard', 'refresh');
		else redirect('/auth/login', 'refresh');
	}

	public function dashboard()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		$data = [];


		$menu = [];
		$sql = "SELECT * FROM menu WHERE role=".$this->db->escape($this->session->userdata('user')['role'])." ORDER BY urut";
		$res = $this->db->query($sql);
		while ($row = $res->unbuffered_row('array')) {
			$menu[] = $row;
		}
		$this->session->set_userdata('menu',$menu);

		// $data['hotline'] = $this->db->get('hotline')->result_array();
		// // var_dump($data);
		// // die();
		// $content = $this->load->view('main',$data, TRUE);

		switch ($this->session->userdata('user')['role']) {
			case 'MAINTAINER' : $content = $this->load->view('dashboard/maintainer', $data, TRUE); break;
			case 'OPERATOR' : $content = $this->load->view('dashboard/operator', $data, TRUE); break;
			case 'UPLOADER' : $content = $this->load->view('dashboard/uploader', $data, TRUE); break;
			case 'VIEWER' : $content = $this->load->view('dashboard/viewer', $data, TRUE); break;
		}

		$this->load->view('main',['content'=>$content]);
	}

}
