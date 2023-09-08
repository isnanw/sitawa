<?php
class M_Pns extends CI_Model
{
    var $column_order = ['p.nip', 'p.nama', 'jumlah', TRUE];
    var $column_search = ['p.nip', 'p.nama', TRUE];
    var $order = ['jumlah' => 'DESC', TRUE];

    private function _get_datatables_query()
    {
        $status = "'PNS'";
        $this->db->select('p.nip as nip,
                                    p.nama as pegawai,
                                    COUNT(CASE
                                            WHEN d.is_delete != true then false
                                            ELSE NULL
                                            END) as jumlah
                                FROM (
                                    SELECT nip,
                                            "nama",
                                            convert_from(decrypt(data, nip::bytea, \'aes\'), \'UTF8\')::jsonb as
                                                data
                                    FROM pns
                                    ) p
                                    LEFT JOIN dms d ON d.uname = p.nip
                                    WHERE p.data ->> \'status_kepegawaian\' = \'PNS\'', FALSE);
        $this->db->group_by('p.nip, p.nama', FALSE);

        // $this->db->query("SELECT X.nip,
        //                   X.nama as pegawai,
        //                   COUNT(CASE
        //                           WHEN d.is_delete != true then false
        //                           ELSE NULL
        //                         END) as jumlah
        //             FROM (
        //                   SELECT nip,
        //                           nama,
        //                           convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as
        //                             data
        //                   FROM pns
        //                 ) X
        //                 LEFT JOIN dms d ON (d.uname = X.nip)
        //             WHERE X.data ->> 'status_kepegawaian' = 'PNS'
        //             GROUP BY X.nip,
        //                     X.nama
    		// 	 ");
        // $this->db->query($query);

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

  }