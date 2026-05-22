<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model');
    }

    public function index() {
        $data['page_title'] = 'Contact Us';
        $data['page'] = 'contact';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/contact');
        $this->load->view('frontend/footer');
    }

    public function submit() {
        // Handle contact form submission
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('contact');
        } else {
            // Prepare data for database
            $data = array(
                'name' => trim($this->input->post('name')),
                'email' => trim($this->input->post('email')),
                'phone' => $this->input->post('phone') ? trim($this->input->post('phone')) : null,
                'subject' => $this->input->post('subject') ? trim($this->input->post('subject')) : null,
                'message' => trim($this->input->post('message')),
                'status' => 'new'
            );
            
            // Save to database
            $contact_id = $this->Contact_model->create($data);
            
            if ($contact_id) {
                $this->session->set_flashdata('success', 'Thank you for contacting us! We will get back to you soon.');
            } else {
                $this->session->set_flashdata('error', 'Sorry, there was an error submitting your message. Please try again.');
            }
            
            redirect('contact');
        }
    }

    public function save() {
        // Handle AJAX contact form submission (for contactus.php)
        header('Content-Type: application/json');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
        
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
        
        // Prepare data for database
        $data = array(
            'name' => trim($this->input->post('name')),
            'email' => trim($this->input->post('email')),
            'phone' => $this->input->post('phone') ? trim($this->input->post('phone')) : null,
            'subject' => $this->input->post('subject') ? trim($this->input->post('subject')) : null,
            'message' => trim($this->input->post('message')),
            'status' => 'new'
        );
        
        // Save to database
        $contact_id = $this->Contact_model->create($data);
        
        if ($contact_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => true,
                    'message' => 'Thank you for contacting us! We will get back to you soon.'
                )));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => false,
                    'message' => 'Failed to save contact form',
                    'errors' => array('message' => 'Database error')
                )));
        }
    }
}
