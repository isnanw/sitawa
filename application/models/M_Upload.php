<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Upload extends CI_Model
{

  public function db_update($data,$id)
  {
      $this->db->where('uname', $id);
      $this->db->update('pengguna', $data);
  }

}