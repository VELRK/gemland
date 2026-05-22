<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {

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
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get('testimonials')->result();
    }

    public function get_active($limit = null)
    {
        $this->db->where('status', 'active');
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('id', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('testimonials')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('testimonials', array('id' => $id))->row();
    }

    public function create($data)
    {
        $this->db->insert('testimonials', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('testimonials', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('testimonials');
    }
}
