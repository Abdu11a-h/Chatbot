<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function getTableData($tbl, $cols, $whr = '', $order = '', $dir = '', $j_tbl = '', $j_val = '', $j_type = '', $group_by = '', $limit = 0, $offset = 0)
    {
        $this->db->select($cols, false);

        if($j_tbl != '' && $j_val != '')
        {
            if($j_type == '')
            {
                $this->db->join($j_tbl,$j_val);
            }
            else
            {
                $this->db->join($j_tbl,$j_val,$j_type);
            }
        }

        if($order != '')
        {
            $dir = ($dir == '') ? 'DESC' : $dir;
            $this->db->order_by($order, $dir);
        }

        if($limit != 0 && $offset == 0)
        {
            $this->db->limit($limit);
            if($group_by != '')
            {
                $this->db->group_by($group_by);
            }
        }
        else if($limit != 0 && $offset != 0)
        {
            $this->db->limit($limit, $offset);
            if($group_by != '')
            {
                $this->db->group_by($group_by);
            }
        }

        if($whr != '')
        {
            $this->db->where($whr);
        }
        $query = $this->db->get($tbl);
        return $query->result();
    }

    public function insert_data($info,$table) // add single admin info
    {
        if ($this->db->insert($table,$info))
        {
            return $this->db->insert_id(); //insertion success
        }
        else
        {
            return 0; // fail
        }
    }

    public function update_data($info,$table,$where) // update single user info
    {
        $this->db->where($where);
        if ($this->db->update($table,$info))
        {
            return 1; //insertion failed
        }
        else
        {
            return 0; // success
        }
    }

    public function delete($tablename,$col_name,$id)
    {
        $this->db->where($col_name,$id);
        if($this->db->delete($tablename))
        {
            return true;
        }

        return false;
    }

    public function delete_data($tablename,$where)
    {
        $this->db->where($where);
        if($this->db->delete($tablename))
        {
            return true;
        }

        return false;
    }

    public function ExecQuery($query)
    {
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getQueriesData($cols, $where, $offset = 0, $limit = 0)
    {
        $this->db->select($cols);
        $this->db->join('area_category ac', 'ac.id = q.subject_area');
        $this->db->join('incomplete_query iq', 'iq.id = q.incomplete_query');
        $this->db->join('payments ps', 'ps.query_id = q.id AND ps.query_type = "1"', 'LEFT');
        $this->db->where($where);
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('q.id', 'ASC');
        $query = $this->db->get('query q');
        return $query->result();
    }

    public function getPlagiarismQueriesData($cols, $where, $offset = 0, $limit = 0)
    {
        $this->db->select($cols);
        $this->db->join('area_category ac', 'ac.id = pq.subject_area');
        $this->db->join('payments ps', 'ps.query_id = pq.id AND ps.query_type = "3"', 'LEFT');
        $this->db->where($where);
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('pq.id', 'ASC');
        $query = $this->db->get('plagiarism_query pq');
        return $query->result();
    }

    public function getQueriesDataDetails($cols, $where, $offset = 0, $limit = 0)
    {
        $this->db->select($cols);
        $this->db->join('area_category ac', 'ac.id = q.subject_area');
        $this->db->join('incomplete_query iq', 'iq.id = q.incomplete_query');
        $this->db->join('word_counts wc', 'iq.word_count >= wc.lower_limit AND iq.word_count <= wc.upper_limit AND iq.standard = wc.standard');
        $this->db->join('delivery_plans dp', 'dp.id = iq.select_delivery_plans');
        $this->db->where($where);
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('q.id', 'ASC');
        $query = $this->db->get('query q');
        return $query->result();
    }
}
?>