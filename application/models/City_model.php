<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('name', 'ASC');
        return $this->db->get('cities')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('cities', array('id' => $id))->row();
    }

    public function get_by_name($name)
    {
        return $this->db->get_where('cities', array('name' => $name))->row();
    }

    public function create($data)
    {
        $this->db->insert('cities', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('cities', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('cities');
    }
}

