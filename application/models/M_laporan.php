<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('tgl_indo');

    }
    public function read($status)
    {

    	if ($status == '1') {
    		$xfilter = 'PNS';
    		$sql = "WHERE data ->> 'status_kepegawaian' = '$xfilter' ";
    	} elseif ($status == '2') {
    		$xfilter = 'CPNS';
    		$sql = "WHERE data ->> 'status_kepegawaian' = '$xfilter' ";
    	} elseif ($status == '3') {
    		$xfilter = 'HONORER';
    		$sql = "WHERE data ->> 'status_kepegawaian' = '$xfilter' ";
    	}else{
    		$xfilter = '';
    		$sql = '';
    	}

    	$query = "

    			SELECT nip,
				       nama,
				       data ->> 'tgl_lahir' as tgl_lahir,
				       data ->> 'jenis_kelamin' as jenis_kelamin,
				       data ->> 'nmskpd' as nmskpd,
				       data ->> 'jabatan_pekerjaan' as jabatan_pekerjaan
				FROM (
				       SELECT nip,
				              nama,
				              convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as data
				       FROM pns
				     ) X
				     $sql
    			 ";
        return $this->db->query($query)->result_array();
    }

    public function readdetail($nip)
    {
    	$query = "
    			SELECT nip,
				       nama,
				       data ->> 'agama' as agama,
				       data ->> 'ruang' as ruang,
				       data ->> 'alamat' as alamat,
				       data ->> 'nmskpd' as nmskpd,
				       data ->> 'status' as status,
				       data ->> 'tgl_lahir' as tgl_lahir,
				       -- (CASE WHEN data ->> 'tgl_lahir' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tgl_lahir')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tgl_lahir,
				       data ->> 'pendidikan' as pendidikan,
				       data ->> 'tempat_lahir' as tempat_lahir,
				       data ->> 'jenis_kelamin' as jenis_kelamin,
				       data ->> 'pangkat_golongan' as pangkat_golongan,
				       data ->> 'jabatan_pekerjaan' as jabatan_pekerjaan,
				       data ->> 'status_kepegawaian' as status_kepegawaian,
				       data ->> 'tmt_pangkat_golongan' as tmt_pangkat_golongan,
				       data ->> 'tmt_jabatan_pekerjaan' as tmt_jabatan_pekerjaan
				       -- (CASE WHEN data ->> 'tmt_pangkat_golongan' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tmt_pangkat_golongan')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tmt_pangkat_golongan,
				       -- (CASE WHEN data ->> 'tmt_jabatan_pekerjaan' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tmt_jabatan_pekerjaan')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tmt_jabatan_pekerjaan
				FROM (
				       SELECT nip,
				              nama,
				              convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as data
				       FROM pns
				     ) X
				 WHERE nip = '$nip'
    			 ";
        return $this->db->query($query)->row_array();
    }

    public function readdokumen($nip)
    {
    	$query = "

    			SELECT * FROM dms WHERE uname = '$nip' AND is_delete != true
    	";

    	return $this->db->query($query)->result_array();
    }
}
