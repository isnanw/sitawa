<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Importdata extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if (@sizeof($this->session->userdata('user'))<1) redirect('/auth/login', 'refresh');
		if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/main/dashboard', 'refresh');
		$data = [
			'judul'			=> 'Import Data',
			'diskripsi' => '<hr>'
		];

		$this->template->render_page('importdata', $data, TRUE);
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
		$sql = "SELECT * FROM log_import ORDER BY tanggal DESC ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT * FROM log_import ORDER BY tanggal DESC ".$filter;
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

	public function doimport()
	{
		if (sizeof($this->session->userdata('user'))<1) die();
		if ($this->session->userdata('user')['role']!='MAINTAINER') die();

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xls';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('berkas')) {
			$file = $this->upload->data();

			$filepath = $config['upload_path'].$file['file_name'];
			$inputFileType = PHPExcel_IOFactory::identify($filepath);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$spreadsheetInfo = $objReader->listWorksheetInfo($filepath);
			$totalRows = $spreadsheetInfo[0]['totalRows'];

			$sql = "INSERT INTO log_import(jumlah,namafile) VALUES(
					".$this->db->escape($totalRows).",
					".$this->db->escape($file['file_name']).") RETURNING kodelog";
			$res = $this->db->query($sql);
			if ($res) {
				$row = $res->row_array();
				$filelog = './logs/'.$row['kodelog'].".log";
				$result = ["status"=>"ok", "msg"=> "Sukses Upload"];
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') exec('php index.php importdata doproses '.$row['kodelog'].' > '.$filelog);
				else exec('nohup setsid php index.php importdata doproses '.$row['kodelog'].' > '.$filelog.' 2>&1 & echo $!',$id);
			} else $result = ["status"=>"error", "msg"=> "Gagal Upload"];

			//php index.php importdata doproses [kodelog]

		} else {
			$result = ["status"=>"error", "msg"=> "Gagal Upload ".$this->upload->display_errors()];
		}
		echo json_encode($result);
	}

	public function doproses($kodelog)
	{
		//proses via cli
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		$kodelog = (int) $kodelog;

		$sql = "SELECT * FROM log_import WHERE kodelog=".$this->db->escape($kodelog);
		$res = $this->db->query($sql)->row_array();
		if ($res>0) {

			$result = ["status"=>"ok", "msg"=> "Sukses Proses"];

			$config['upload_path'] = './uploads/';

			$filepath = $config['upload_path'].$res['namafile'];
			$inputFileType = PHPExcel_IOFactory::identify($filepath);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$spreadsheetInfo = $objReader->listWorksheetInfo($filepath);
			$totalRows = $spreadsheetInfo[0]['totalRows'];

			$chunkFilter = new ChunkReadFilter();
			$objReader->setReadFilter($chunkFilter);
			$chunkSize = 1000;
			$this->db->query('START TRANSACTION');

			//flag status
			$this->db->query("update pns set status=0");
			$sukses = true;
			$key = [];
			for ($startRow = 0; $startRow <= $totalRows; $startRow += $chunkSize) {
				$chunkFilter->setRows($startRow, $chunkSize);
				$objPHPExcel = $objReader->load($filepath);
				$objWorksheet = $objPHPExcel->getActiveSheet();
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

				for ($row = $startRow; $row <= $highestRow; $row++) {
					if ($row==1) {
						for ($col = 1; $col <= $highestColumnIndex; $col++) {
							$key[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						}
					} else if ($row>1) {
						$data = [];
						$nip = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
						$nama = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
						for ($col = 1; $col <= $highestColumnIndex; $col++) {
							$data[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						}

						//ini jika ada diupdate datanya dan nama, flag di aktifkan
						$json = json_encode(array_combine($key, $data));
						$sql = "insert into pns(nip,nama,status,data) values(".$this->db->escape($nip).",".$this->db->escape($nama).",1,encrypt('".pg_escape_bytea($json)."',".$this->db->escape($nip).",'aes')) on conflict(nip) do update set nama=EXCLUDED.nama, data=EXCLUDED.data, status=1";
						//echo $sql."\n";
						if(!@$this->db->query($sql)) {
							$sukses = false;
							//echo $this->db->lastError()."\n";
							//echo $sql."\n";
							$result = ["status"=>"error", "msg"=> "Gagal Proses "];
							break 2;
						}
					}
				}
				unset($objPHPExcel,$objWorksheet);
			}
			if ($sukses) $this->db->query('COMMIT');
			else $this->db->query('ROLLBACK');
		} else {
			$result = ["status"=>"error", "msg"=> "Gagal Proses"];
		}
		echo json_encode($result);
	}

}
