<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Testimonial_model');
    }

    public function index() {
        $data['page_title'] = 'About Us';
        $data['page'] = 'about';
        $data['testimonials'] = $this->Testimonial_model->get_active();

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/about', $data);
        $this->load->view('frontend/footer');
    }
}
