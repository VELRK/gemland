<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('page_seo')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('page_seo', array('id' => $id))->row();
    }

    public function get_by_key($key)
    {
        return $this->db->get_where('page_seo', array('page_key' => $key))->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('page_seo', $data);
    }
}
