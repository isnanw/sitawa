<?php
// defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf as Dompdf;

class Laporan extends CI_Controller {

 public function __construct()
    {
        parent::__construct();

        $this->load->model('M_laporan');
        $this->load->helper('tgl_indo');

    }

	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER','VIEWER'])) redirect('/mainku/dashboard', 'refresh');

		$data = [
			'judul'			=> 'Laporan',
			'diskripsi' => '<hr>'
		];

		// $content = $this->load->view('laporan/index', $data, TRUE);

		// $this->load->view('main',['content'=>$content]);
		$this->template->render_page('laporan/index', $data, TRUE);
	}

	//fungsi-fungsi AJAX
	public function list($jenis='')
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER','VIEWER'])) die();
		$jenis = urldecode($jenis);

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length>0) $filter = " LIMIT ".$length." OFFSET ".$start;
		else $filter="";

		switch ($jenis) {
			case "belumkgb": $laporan = " to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)<now() "; break;
			case "kgbbulanini": $laporan = " to_char(to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400),'YYYY-MM')=to_char(now(),'YYYY-MM') "; break;
			case "58tahun": $laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) between 58 and 59 "; break;
			case "60tahun": $laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) between 60 and 64 "; break;
			case "65tahun": $laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) >= 65 "; break;
			default : $laporan = " 1=2 "; break;
		}

		$search = '';
		if ($this->input->post("search")['value']!='') $search = "AND nama like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT nip,nama,data->>'nmskpd' as skpd,
					   DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) as usia,
					   to_timestamp(((data->>'tmtkgb')::bigint - 25569) * 86400)::date as kgb,
					   to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)::date as kgbyad
				FROM (
		           SELECT nip,nama,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns
				) X WHERE ".$laporan." ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT nip,nama,data->>'nmskpd' as skpd,
					   DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) as usia,
					   to_timestamp(((data->>'tmtkgb')::bigint - 25569) * 86400)::date as kgb,
					   to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)::date as kgbyad
				FROM (
		           SELECT nip,nama,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns
				) X WHERE ".$laporan." ".$search." ORDER BY data->>'nmskpd',nip DESC ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}


	public function listdetail()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER','VIEWER'])) die();

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length>0) $filter = " LIMIT ".$length." OFFSET ".$start;
		else $filter="";

		$search = '';
		if ($this->input->post("search")['value']!='') $search = "WHERE LOWER(nama) like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		$sql = "SELECT * FROM pns ".$search." ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "
				       SELECT nip,
				              nama,
				              convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as data
				       FROM pns ".$search." ORDER BY nip ".$filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$json = json_decode($row["data"],true);
			$row['nama'] = $json['nama'];
			$row['tgl_lahir'] = $json['tgl_lahir'];
			$row['nmskpd'] = $json['nmskpd'];
			$row['jabatan_pekerjaan'] = $json['jabatan_pekerjaan'];
			$row['jenis_kelamin'] = $json['jenis_kelamin'];
			$row['detail'] = "<a href=".base_url('Laporan/cetakdetail?nip=').$row['nip']." class=\"btn btn-sm btn-danger\" target=\"_blank\"><i class=\"fa fa-print\"></i></a>
			<a href=".base_url('managedocument/detaildoklaporan/').$row['nip']." class=\"btn btn-sm btn-info\"><i class=\"fa fa-file-word\"></i></a>";
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}

	public function cetak()
    {
        $data['title'] = 'Laporan';
        $data['hariini'] = date('d F Y');
        $status = $this->input->post('filter');

        if ($status == 1) {
    		$xfilter = 'PNS';
    	} elseif ($status == 2) {
    		$xfilter = 'CPNS';
    	} elseif ($status == 3) {
    		$xfilter = 'HONORER';
    	}else{
    		$xfilter = '';
    	}

    	// die($status);

    	$data['sfilter'] = $xfilter;
        $data['list'] = $this->M_laporan->read($status);

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'Portrait');
        $html = $this->load->view('laporan/cetak', $data, true);
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream('Laporan Data ', array("Attachment" => false));
    }

    public function cetakdetail()
    {
        $data['title'] = 'Laporan';
        $data['hariini'] = date('d F Y');
        $nip = $this->input->get('nip');
        $tgl = $this->M_laporan->readdetail($nip);

        $data['list'] = $this->M_laporan->readdetail($nip);

        $data['dokumen'] = $this->M_laporan->readdokumen($nip);

        $data['tgl_lahir'] = mediumdate_indo($tgl['tgl_lahir']);

        $data['tglpangkat'] = mediumdate_indo($tgl['tmt_pangkat_golongan']);

        $data['tgljabatan'] = mediumdate_indo($tgl['tmt_jabatan_pekerjaan']);

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'Portrait');
        $html = $this->load->view('laporan/cetakdetail', $data, true);
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream('Laporan Detail Pegawai ', array("Attachment" => false));
    }


}
