<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($status = null)
    {
        if ($status) {
            $this->db->where('enquiries.status', $status);
        }
        $this->db->select('enquiries.*, properties.name as property_name');
        $this->db->from('enquiries');
        $this->db->join('properties', 'properties.id = enquiries.property_id', 'left');
        $this->db->order_by('enquiries.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('enquiries.*, properties.name as property_name');
        $this->db->from('enquiries');
        $this->db->join('properties', 'properties.id = enquiries.property_id', 'left');
        $this->db->where('enquiries.id', $id);
        return $this->db->get()->row();
    }

    public function create($data)
    {
        // Remove any fields that don't exist in the table
        $allowed_fields = array('property_id', 'name', 'email', 'phone', 'message', 'status');
        $filtered_data = array();
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $filtered_data[$field] = $data[$field];
            }
        }
        
        // Ensure required fields are present
        if (empty($filtered_data['name']) || empty($filtered_data['email'])) {
            return false;
        }
        
        // Insert data
        $result = $this->db->insert('enquiries', $filtered_data);
        
        if ($result) {
            return $this->db->insert_id();
        } else {
            // Log error for debugging
            $error = $this->db->error();
            if (!empty($error['message'])) {
                log_message('error', 'Enquiry insert failed: ' . $error['message']);
            } else {
                log_message('error', 'Enquiry insert failed: Unknown database error');
            }
            return false;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('enquiries', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('enquiries');
    }

    public function count_new()
    {
        return $this->db->where('status', 'new')->count_all_results('enquiries');
    }

    /**
     * Get enquiries by customer ID (filtered by user's email or phone)
     * @param int $customer_id User ID
     * @param string $status Optional status filter
     * @return array List of enquiries
     */
    public function get_by_customer_id($customer_id, $status = null)
    {
        // First get the user details
        if (!class_exists('User_model')) {
            $this->load->model('User_model');
        }
        $user = $this->User_model->get_by_id($customer_id);
        
        if (!$user) {
            return array();
        }
        
        // Build query to match enquiries by email or phone
        $this->db->select('enquiries.*, properties.name as property_name, properties.main_image as property_image');
        $this->db->from('enquiries');
        $this->db->join('properties', 'properties.id = enquiries.property_id', 'left');
        
        // Match by email or phone
        $has_email = !empty($user->email);
        $has_phone = !empty($user->phone);
        
        if ($has_email || $has_phone) {
            $this->db->group_start();
            if ($has_email) {
                $this->db->where('enquiries.email', $user->email);
            }
            if ($has_phone) {
                if ($has_email) {
                    $this->db->or_where('enquiries.phone', $user->phone);
                } else {
                    $this->db->where('enquiries.phone', $user->phone);
                }
            }
            $this->db->group_end();
        } else {
            // If user has neither email nor phone, return empty array
            return array();
        }
        
        if ($status) {
            $this->db->where('enquiries.status', $status);
        }
        
        $this->db->order_by('enquiries.created_at', 'DESC');
        
        return $this->db->get()->result();
    }
}

