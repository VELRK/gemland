<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Property_model');
        $this->load->model('Category_model');
        $this->load->model('City_model');
        $this->load->model('Location_model');
        $this->load->helper('property');
    }

    private function _get_filters() {
        return array(
            'category' => trim($this->input->get('category')),
            'city'     => trim($this->input->get('city')),
            'location' => trim($this->input->get('location')),
        );
    }

    private function _load_filter_options(&$data) {
        $data['categories'] = $this->Category_model->get_all('active');
        $data['cities']     = $this->City_model->get_all('active');
        $data['locations']  = $this->Location_model->get_all('active');
        $data['filters']    = $this->_get_filters();
    }

    private function _get_properties($process, $filters) {
        $filters['process'] = $process;
        $active_filters = array_filter($filters);
        if (empty($active_filters) || (count($active_filters) === 1 && isset($active_filters['process']))) {
            return $this->Property_model->get_by_process($process);
        }
        return $this->Property_model->search($filters);
    }

    public function index() {
        $filters = $this->_get_filters();
        $data['page_title']     = 'Our Projects';
        $data['page']           = 'projects';
        $data['project_status'] = 'all';
        $data['properties']     = $this->_get_properties('all', $filters);
        $this->_load_filter_options($data);

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/projects', $data);
        $this->load->view('frontend/footer');
    }

    public function ongoing() {
        $filters = $this->_get_filters();
        $data['page_title']     = 'Ongoing Projects';
        $data['page']           = 'projects';
        $data['project_status'] = 'ongoing';
        $data['properties']     = $this->_get_properties('Ongoing', $filters);
        $this->_load_filter_options($data);

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/projects', $data);
        $this->load->view('frontend/footer');
    }

    public function upcoming() {
        $filters = $this->_get_filters();
        $data['page_title']     = 'Upcoming Projects';
        $data['page']           = 'projects';
        $data['project_status'] = 'upcoming';
        $data['properties']     = $this->_get_properties('Upcoming', $filters);
        $this->_load_filter_options($data);

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/projects', $data);
        $this->load->view('frontend/footer');
    }

    public function completed() {
        $filters = $this->_get_filters();
        $data['page_title']     = 'Completed Projects';
        $data['page']           = 'projects';
        $data['project_status'] = 'completed';
        $data['properties']     = $this->_get_properties('Completed', $filters);
        $this->_load_filter_options($data);

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/projects', $data);
        $this->load->view('frontend/footer');
    }
}
