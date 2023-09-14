<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mainku extends CI_Controller
{
  public function __construct()
    {
        parent::__construct();
        if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');

        $this->user = $this->db->get_where('pengguna', ['uname' => $this->session->userdata('uname')])->row_array();

        $this->load->model('M_ManageDocument', 'mmd');
        $this->load->helper('tgl_indo');
    }

    public function index(){
      if (@sizeof($this->session->userdata('user'))>1) redirect('/mainku/dashboard', 'refresh');
		  else redirect('/auth/login', 'refresh');
      // $this->template->render_page('login', $data);
    }

    public function dashboard()
    {
      if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');

      $data = [
        'judul' => "Dashboard",
        // 'jenisdokumen'  => $this->db->order_by('kodeberkas', 'ASC')->get('jenisdok')->result_array(),
        'jenisdokumen'    => $this->db->query('select
                                              j.kodeberkas,
                                              coalesce(COUNT(p.*),
                                              0) as jumlah
                                            from jenisdok j
                                            left join
                                                dms d
                                            on
                                              (j.kodeberkas = d.kodeberkas)
                                            left join (
                                              select
                                                nip,
                                                convert_from(decrypt(data,
                                                nip::bytea,
                                                \'aes\'),
                                                \'UTF8\')::jsonb as data
                                              from
                                                pns
                                                ) p
                                            on
                                              (p.data ->>\'nip\' = d.uname)
                                            where
                                              d.kodeberkas is not null
                                            --	and p.data ->> \'status_kepegawaian\' = \'CPNS\'
                                            group by
                                              j.kodeberkas
                                            order by
                                              jumlah DESC;')->result_array(),
      'dokumenpns' => $this->db->query('select
                                              j.kodeberkas,
                                              coalesce(COUNT(p.*),
                                              0) as jumlah
                                            from jenisdok j
                                            left join
                                                dms d
                                            on
                                              (j.kodeberkas = d.kodeberkas)
                                            left join (
                                              select
                                                nip,
                                                convert_from(decrypt(data,
                                                nip::bytea,
                                                \'aes\'),
                                                \'UTF8\')::jsonb as data
                                              from
                                                pns
                                                ) p
                                            on
                                              (p.data ->>\'nip\' = d.uname)
                                            where
                                              d.kodeberkas is not null
                                              and p.data ->> \'status_kepegawaian\' = \'PNS\'
                                            group by
                                              j.kodeberkas
                                            order by
                                              jumlah DESC;')->result_array(),
      'dokumencpns' => $this->db->query('select
                                              j.kodeberkas,
                                              coalesce(COUNT(p.*),
                                              0) as jumlah
                                            from jenisdok j
                                            left join
                                                dms d
                                            on
                                              (j.kodeberkas = d.kodeberkas)
                                            left join (
                                              select
                                                nip,
                                                convert_from(decrypt(data,
                                                nip::bytea,
                                                \'aes\'),
                                                \'UTF8\')::jsonb as data
                                              from
                                                pns
                                                ) p
                                            on
                                              (p.data ->>\'nip\' = d.uname)
                                            where
                                              d.kodeberkas is not null
                                              and p.data ->> \'status_kepegawaian\' = \'CPNS\'
                                            group by
                                              j.kodeberkas
                                            order by
                                              jumlah DESC;')->result_array(),
      'dokumenhonorer' => $this->db->query('select
                                              j.kodeberkas,
                                              coalesce(COUNT(p.*),
                                              0) as jumlah
                                            from jenisdok j
                                            left join
                                                dms d
                                            on
                                              (j.kodeberkas = d.kodeberkas)
                                            left join (
                                              select
                                                nip,
                                                convert_from(decrypt(data,
                                                nip::bytea,
                                                \'aes\'),
                                                \'UTF8\')::jsonb as data
                                              from
                                                pns
                                                ) p
                                            on
                                              (p.data ->>\'nip\' = d.uname)
                                            where
                                              d.kodeberkas is not null
                                              and p.data ->> \'status_kepegawaian\' = \'Honorer\'
                                            group by
                                              j.kodeberkas
                                            order by
                                              jumlah DESC;')->result_array(),
        'jumlahpegawai' => $this->mmd->countPegawai(),
        'jumlahcpns' => $this->mmd->countCPNS(),
        'jumlahpns' => $this->mmd->countPNS(),
        'jumlahhonorer' => $this->mmd->countHonorer(),
      ];

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
        case 'MAINTAINER' : $content =  $this->template->render_page('das', $data); break;
        case 'OPERATOR' : $content = $this->template->render_page('das', $data); break;
        case 'UPLOADER' : $content = $this->template->render_page('das1', $data); break;
        case 'VIEWER' : $content = $this->template->render_page('das', $data); break;
      }

    }

    public function list()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if (!in_array($this->session->userdata('user')['role'],['OPERATOR','MAINTAINER','VIEWER'])) die();

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length>0) $filter = " LIMIT ".$length." OFFSET ".$start;
		else $filter="";

		// $search = '';
		// if ($this->input->post("search")['value']!='') $search = "AND LOWER(nama) like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		// $sql = "SELECT * FROM pns ".$search." ";

		$sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns WHERE tgl_kenaikan_pangkat IS NOT NULL AND tgl_kenaikan_pangkat >= now() AND tgl_kenaikan_pangkat < CURRENT_DATE + INTERVAL '3 months' OR
      tgl_kgb >= now() AND
      tgl_kgb < CURRENT_DATE + INTERVAL '3 months' ORDER BY nip ".$filter;
    // die($sql);
		$totaldata = $this->db->query($sql)->num_rows();
		$res = $this->db->query($sql);
		$data = [];

    $t = time();

		while ($row = $res->unbuffered_row('array')) {
      // $hari = date('d', $row['tgl_kenaikan_pangkat']);
      // $bulan = date('m', $row['tgl_kenaikan_pangkat']);
      // $tahun = date('y', $row['tgl_kenaikan_pangkat']);
      $tgl = $row['tgl_kenaikan_pangkat'];
      $ubah = gmdate($tgl, time()+60*60*8);
            // die($ubah);
      $pecah = explode("-",$ubah);
      $hari = @$pecah[2];
      $bulan = @$pecah[1];
      $tahun = @$pecah[0];

      $target = @mktime(0, 0, 0, @$bulan, @$hari, @$tahun) ;
      $hari_ini = time () ;
      $rentang =($target-$hari_ini) ;
      $harigas =(int) ($rentang/86400) ;

      $tglkgb = $row['tgl_kgb'];
      $ubahkgb = gmdate($tglkgb, time()+60*60*8);
            // die($ubah);
      $pecahkgb = explode("-",$ubahkgb);
      $harikgb = @$pecahkgb[2];
      $bulankgb = @$pecahkgb[1];
      $tahunkgb = @$pecahkgb[0];

      $targetkgb = @mktime(0, 0, 0, $bulankgb, $harikgb, $tahunkgb) ;
      $hari_inikgb = time () ;
      $rentangkgb =($targetkgb-$hari_inikgb) ;
      $harigaskgb =(int) ($rentangkgb/86400) ;

			$json = json_decode($row["data"],true);

      if($tgl != Null){
        $kp = "<b>". $harigas ." hari </b> lagi hingga tanggal <b>". mediumdate_indonesia($row['tgl_kenaikan_pangkat']) ."</b>";
      }else{
        $kp = "-";
      }

      if($tglkgb != Null){
        $kgb = "<b>". $harigaskgb ." hari </b> lagi hingga tanggal <b>". mediumdate_indonesia($row['tgl_kgb']) ."<b>";
      }else{
        $kgb = '-';
      }

			$row['nip'] = $json['nip'];
			$row['nama'] = $json['nama'];
			// $row['tanggal'] = mediumdate_indonesia($row['tgl_kenaikan_pangkat']);
      $row['tanggal'] ="KP : $kp <hr> KGB : $kgb";
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null?[]:$data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}
}