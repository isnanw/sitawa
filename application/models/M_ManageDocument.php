<?php
class M_ManageDocument extends CI_Model
{
    var $column_order = ['p.nip', 'p.nama', 'jumlah'];
    var $column_search = ['p.nip', 'p.nama'];
    var $order = ['jumlah' => 'DESC'];

    private function _get_datatables_query()
    {
        $this->db->select('p.nip as nip,
                          p.nama as pegawai,
                          COUNT(CASE WHEN d.is_delete != true then false ELSE NULL END) as jumlah');
        $this->db->from('pns p');
        $this->db->join('dms d', 'd.uname = p.nip','LEFT');
        $this->db->group_by('p.nip, p.nama');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    // $this->db->like($item, $_POST['search']['value']);
                    $this->db->like('LOWER(' .$item. ')', strtolower($_POST['search']['value']));
                } else {
                    $this->db->or_like('LOWER(' .$item. ')', strtolower($_POST['search']['value']));
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);

        // if (isset($_POST['order'])) {
        //     $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->db->order_by(key($order), $order[key($order)]);
        // }
    }

    public function countJP()
    {
        $jumlahpegawai = $this->db->query('SELECT COUNT(DISTINCT uname) as jumlah FROM dms WHERE uname IS NOT null');
        $row = $jumlahpegawai->row();

        return $row->jumlah;
    }

    public function countDock()
    {
        $jumlahdok = $this->db->query('SELECT COUNT(*) as jumlah FROM dms');

        $row = $jumlahdok->row();

        return $row->jumlah;
    }

    public function countPegawai()
    {
       $jumlahpns = $this->db->query('SELECT COUNT(*) as jumlah FROM pns');

        $row = $jumlahpns->row();

        return $row->jumlah;
    }

    public function countPNS()
    {
       $jumlahpns = $this->db->query("SELECT COUNT(*) as jumlah FROM (
                        SELECT nip,
                                nama,
                                convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as
                                    data
                        FROM pns
                        ) pns
                    WHERE data ->> 'status_kepegawaian' = 'PNS'");

        $row = $jumlahpns->row();

        return $row->jumlah;
    }

    public function countCPNS()
    {
       $jumlahpns = $this->db->query("SELECT COUNT(*) as jumlah FROM (
                        SELECT nip,
                                nama,
                                convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as
                                    data
                        FROM pns
                        ) pns
                    WHERE data ->> 'status_kepegawaian' = 'CPNS'");

        $row = $jumlahpns->row();

        return $row->jumlah;
    }

    public function countHonorer()
    {
       $jumlahpns = $this->db->query("SELECT COUNT(*) as jumlah FROM (
                        SELECT nip,
                                nama,
                                convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as
                                    data
                        FROM pns
                        ) pns
                    WHERE data ->> 'status_kepegawaian' = 'Honorer'");

        $row = $jumlahpns->row();

        return $row->jumlah;
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function hitungLabelnegatif()
    {
      $query = $this->db->query('SELECT * FROM komentar WHERE label= "negatif"');
      $negatif=$query->num_rows();
      return $negatif;
    }

    public function count_all()
    {
        $this->db->from('dms');
        return $this->db->count_all_results();
    }

    public function getDMS($id)
    {
        $this->db->select('p.nip as nip,
                          p.nama as pegawai');
        $this->db->from('pns p');
        // $this->db->join('dms d', 'd.uname = p.nip','LEFT');
        $this->db->where('p.nip', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function jenisdok(){
        return $this->db->get('jenisdok')->result_array();
    }

    public function insert_data($file = false)
    {
        $data = [
            'jenis_id' => $this->input->post('jenis_id', true),
            'no_agenda' => $this->input->post('no_agenda', true),
            'pengirim' => $this->input->post('pengirim', true),
            'no_surat' => $this->input->post('no_surat', true),
            'isi' => $this->input->post('isi', true),
            'tgl_surat' => $this->input->post('tgl_surat', true),
            'tgl_diterima' => $this->input->post('tgl_diterima', true),
            'keterangan' => $this->input->post('keterangan', true),
            'user_id' => $this->input->post('user_id'),
        ];

        if ($file != false) {
          $data['file'] = $file;
        }

        $this->db->insert('surat_masuk', $data);
        $this->session->set_flashdata('msg', 'ditambahkan.');
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function update_data($file = false)
    {

        $id = $this->input->post('id');
        $jenis_id = $this->input->post('jenis_id', true);
        $no_agenda = $this->input->post('no_agenda', true);
        $pengirim = $this->input->post('pengirim', true);
        $no_surat = $this->input->post('no_surat', true);
        $isi = $this->input->post('isi', true);
        $tgl_surat = $this->input->post('tgl_surat', true);
        $tgl_diterima = $this->input->post('tgl_diterima', true);
        $keterangan = $this->input->post('keterangan', true);
        $user_id = $this->input->post('user_id');

        if ($file != false) {
            $data['surat'] = $this->db->get_where('surat_masuk', ['id' => $id])->row_array();
            unlink(FCPATH . './uploads/' . $data['surat']['file']);

            $this->db->set('file', $file);
        }

        $this->db->set('jenis_id', $jenis_id);
        $this->db->set('no_agenda', $no_agenda);
        $this->db->set('pengirim', $pengirim);
        $this->db->set('no_surat', $no_surat);
        $this->db->set('isi', $isi);
        $this->db->set('tgl_surat', $tgl_surat);
        $this->db->set('tgl_diterima', $tgl_diterima);
        $this->db->set('keterangan', $keterangan);
        $this->db->set('user_id', $user_id);

        $this->db->where('id', $id);
        $this->db->update('surat_masuk');
        $this->session->set_flashdata('msg', 'diperbarui.');
        $data['status'] = TRUE;
        echo json_encode($data);
    }

}
