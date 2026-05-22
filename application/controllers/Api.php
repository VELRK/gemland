<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Enquiry_model');
        $this->load->library('form_validation');
    }

    /**
     * Store property enquiry
     * POST /api/enquiry/store
     */
    public function enquiry_store()
    {
        // Enable CORS if needed
        header('Content-Type: application/json');
        
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('message', 'Message', 'trim');
        $this->form_validation->set_rules('property_id', 'Property ID', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->form_validation->error_array()
                )));
            return;
        }

        // Prepare data - don't set created_at as it's auto-set by database
        $data = array(
            'property_id' => $this->input->post('property_id') ? (int)$this->input->post('property_id') : null,
            'name' => trim($this->input->post('name')),
            'email' => trim($this->input->post('email')),
            'phone' => $this->input->post('phone') ? trim($this->input->post('phone')) : null,
            'message' => $this->input->post('message') ? trim($this->input->post('message')) : null,
            'status' => 'new'
        );

        // Save enquiry
        try {
            $id = $this->Enquiry_model->create($data);
            
            if ($id) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array(
                        'success' => true,
                        'message' => 'Enquiry submitted successfully!',
                        'id' => $id
                    )));
            } else {
                // Get database error
                $db_error = $this->db->error();
                log_message('error', 'Enquiry save failed: ' . print_r($db_error, true));
                
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array(
                        'success' => false,
                        'message' => 'Failed to save enquiry. Please try again.',
                        'debug' => ENVIRONMENT === 'development' ? $db_error : null
                    )));
            }
        } catch (Exception $e) {
            log_message('error', 'Enquiry save exception: ' . $e->getMessage());
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => false,
                    'message' => 'An error occurred while saving your enquiry. Please try again.',
                    'debug' => ENVIRONMENT === 'development' ? $e->getMessage() : null
                )));
        }
    }
}

