<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))>1) redirect('/main/dashboard', 'refresh');
		else redirect('/auth/login', 'refresh');
	}

	public function login()
	{
		$this->load->view('loginku');
		// $data['judul'] = "LOGIN SITAWA";
		// $this->template->render_page('loginku', $data);
	}

	public function logout()
	{
		session_destroy();
		$this->load->view('loginku');
	}

	public function dologin()
	{
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$sql = "SELECT * FROM vusers WHERE md5(uname)=".$this->db->escape($username)." AND pass = crypt(".$this->db->escape($password).", pass)";
		$res = $this->db->query($sql)->row_array();
		if ($res>0) {
			$this->session->set_userdata('user',$res);
			redirect('/mainku/dashboard', 'refresh');
		} else {
			$this->session->set_flashdata('login_msg', 'Maaf username atau password tidak sesuai');
			$this->session->unset_userdata('user');
			$this->session->unset_userdata('menu');
			redirect('/auth/login', 'refresh');
		}
	}

}
