<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Property_model');
        $this->load->model('Banner_model');
        $this->load->model('Offer_banner_model');
        $this->load->model('Enquiry_model');
        $this->load->model('Contact_model');
        $this->load->model('City_model');
        $this->load->model('Location_model');
        $this->load->model('Category_model');
        $this->load->model('Blog_model');
        $this->load->model('Seo_model');
        $this->load->model('Testimonial_model');
        $this->load->model('Process_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    private function check_login()
    {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $admin = $this->Admin_model->login($username, $password);
            if ($admin) {
                $this->session->set_userdata(array(
                    'admin_logged_in' => true,
                    'admin_id' => $admin->id,
                    'admin_username' => $admin->username
                ));
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password');
            }
        }

        $this->load->view('admin/login');
    }

    public function logout()
    {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin_username');
        redirect('admin/login');
    }

    public function dashboard()
    {
        $this->check_login();
        
        $data['total_properties'] = $this->Property_model->count_all();
        $data['active_properties'] = $this->Property_model->count_all('active');
        $data['total_banners'] = count($this->Banner_model->get_all());
        $data['new_enquiries'] = $this->Enquiry_model->count_new();
        $data['new_contacts'] = $this->Contact_model->count_new();
        
        $this->load->view('admin/header');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }

    // Properties Management
    public function properties()
    {
        $this->check_login();
        $data['properties'] = $this->Property_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/properties/list', $data);
        $this->load->view('admin/footer');
    }

    public function property_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $data = array(
                'category' => $this->input->post('category'),
                'location' => $this->input->post('location'),
                'city' => $this->input->post('city'),
                'price' => $this->input->post('price'),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'total_plot' => $this->input->post('total_plot'),
                'available_size' => $this->input->post('available_size'),
                'video' => $this->input->post('video'),
                'type' => $this->input->post('type'),
                'status' => $this->input->post('status') ?: 'active',
                'is_latest' => $this->input->post('is_latest') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0
            );

            // Handle gallery upload - Multiple images
            $gallery_files = array();
            
            // Keep existing gallery images if editing
            $existing_gallery = $this->input->post('existing_gallery');
            if ($existing_gallery && is_array($existing_gallery)) {
                $gallery_files = $existing_gallery;
            }
            
            // Add new gallery images
            if (!empty($_FILES['gallery']['name'][0])) {
                $files = $_FILES['gallery'];
                $count = count($files['name']);
                
                // Ensure upload directory exists
                $upload_path = './assets/images/property/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] == 0) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];
                        
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                        $config['max_size'] = 5120; // 5MB
                        $config['encrypt_name'] = TRUE; // Prevent overwriting
                        
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
                            $gallery_files[] = 'assets/images/property/' . $upload_data['file_name'];
                        }
                    }
                }
            }
            
            // Store gallery as JSON array in database
            if (!empty($gallery_files)) {
                $data['gallery'] = json_encode($gallery_files);
            } else {
                // Set empty array if no images
                $data['gallery'] = json_encode(array());
            }

            // Handle main image upload
            if (!empty($_FILES['main_image']['name'])) {
                $config['upload_path'] = './assets/images/property/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('main_image')) {
                    $data['main_image'] = 'assets/images/property/' . $this->upload->data('file_name');
                }
            }

            // Handle location URL
            if ($this->input->post('location_url')) {
                $data['location_url'] = $this->input->post('location_url');
            }

            // Handle floorplan upload
            if (!empty($_FILES['floorplan']['name'])) {
                $config['upload_path'] = './assets/images/property/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('floorplan')) {
                    $data['floorplan'] = 'assets/images/property/' . $this->upload->data('file_name');
                }
            }

            // Handle nearby places with title and distance
            $nearby_titles = $this->input->post('nearby_title');
            $nearby_distances = $this->input->post('nearby_distance');
            $nearby_places = array();
            
            if ($nearby_titles && is_array($nearby_titles) && $nearby_distances && is_array($nearby_distances)) {
                foreach ($nearby_titles as $index => $title) {
                    $title = trim($title);
                    $distance = isset($nearby_distances[$index]) ? trim($nearby_distances[$index]) : '';
                    
                    if (!empty($title) && !empty($distance)) {
                        $nearby_places[] = array(
                            'title' => $title,
                            'distance' => $distance
                        );
                    }
                }
            }
            
            if (!empty($nearby_places)) {
                $data['nearby'] = json_encode($nearby_places);
            } else {
                $data['nearby'] = json_encode(array());
            }

            // Handle features (name + optional icon)
            $feature_names = $this->input->post('feature_name');
            $feature_icons = $this->input->post('feature_icon');
            $features_array = array();
            if ($feature_names && is_array($feature_names)) {
                foreach ($feature_names as $index => $name) {
                    $name = trim($name);
                    $icon = isset($feature_icons[$index]) ? trim($feature_icons[$index]) : '';
                    if (!empty($name)) {
                        $features_array[] = array('name' => $name, 'icon' => $icon);
                    }
                }
            }
            $data['features'] = json_encode($features_array);

            // Generate slug from property name
            $this->load->helper('slug');
            if (!empty($data['name'])) {
                $data['slug'] = generate_unique_slug($data['name']);
            }

            $this->Property_model->create($data);
            $this->session->set_flashdata('success', 'Property created successfully');
            redirect('admin/properties');
        }

        $data['cities'] = $this->City_model->get_all('active');
        $all_locations = $this->Location_model->get_all('active');
        $data['categories'] = $this->Category_model->get_all('active');
        
        // Group locations by city for easier filtering
        $data['locations_by_city'] = array();
        foreach ($all_locations as $location) {
            if (!isset($data['locations_by_city'][$location->city_id])) {
                $data['locations_by_city'][$location->city_id] = array();
            }
            $data['locations_by_city'][$location->city_id][] = $location;
        }
        $data['all_locations'] = $all_locations;
        
        $this->load->view('admin/header');
        $this->load->view('admin/properties/create', $data);
        $this->load->view('admin/footer');
    }

    public function property_edit($id)
    {
        $this->check_login();
        $property = $this->Property_model->get_by_id($id);
        $data['property'] = $property;
        
        if (!$property) {
            show_404();
        }

        if ($this->input->post()) {
            $update_data = array(
                'category' => $this->input->post('category'),
                'location' => $this->input->post('location'),
                'city' => $this->input->post('city'),
                'price' => $this->input->post('price'),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'total_plot' => $this->input->post('total_plot'),
                'available_size' => $this->input->post('available_size'),
                'video' => $this->input->post('video'),
                'type' => $this->input->post('type'),
                'status' => $this->input->post('status') ?: 'active',
                'is_latest' => $this->input->post('is_latest') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'process' => $this->input->post('process') ?: 'Upcoming'
            );

            // Handle gallery upload - Multiple images (Edit mode)
            $gallery_files = array();
            
            // Keep existing gallery images that were not removed
            $existing_gallery = $this->input->post('existing_gallery');
            if ($existing_gallery && is_array($existing_gallery)) {
                $gallery_files = $existing_gallery;
            } else {
                // If no existing gallery posted (all removed), set empty array
                $gallery_files = array();
            }
            
            // Add new gallery images
            if (!empty($_FILES['gallery']['name'][0])) {
                $files = $_FILES['gallery'];
                $count = count($files['name']);
                
                // Ensure upload directory exists
                $upload_path = './assets/images/property/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] == 0) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];
                        
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                        $config['max_size'] = 5120; // 5MB
                        $config['encrypt_name'] = TRUE; // Prevent overwriting
                        
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
                            $gallery_files[] = 'assets/images/property/' . $upload_data['file_name'];
                        }
                    }
                }
            }
            
            // Delete removed gallery images from server
            if ($property->gallery) {
                $old_gallery = json_decode($property->gallery, true) ?: array();
                foreach ($old_gallery as $old_img) {
                    // If image was removed (not in new gallery), delete the file
                    if (!in_array($old_img, $gallery_files) && !empty($old_img) && file_exists('./' . $old_img)) {
                        @unlink('./' . $old_img);
                    }
                }
            }
            
            // Store gallery as JSON array in database (even if empty, to clear gallery)
            $update_data['gallery'] = !empty($gallery_files) ? json_encode($gallery_files) : json_encode(array());

            // Handle main image removal
            if ($this->input->post('remove_main_image') == '1') {
                // Delete old main image file if exists
                if (!empty($property->main_image) && file_exists('./' . $property->main_image)) {
                    @unlink('./' . $property->main_image);
                }
                $update_data['main_image'] = '';
            }
            
            // Handle main image upload
            if (!empty($_FILES['main_image']['name'])) {
                // Delete old main image file if exists
                if (!empty($property->main_image) && file_exists('./' . $property->main_image)) {
                    @unlink('./' . $property->main_image);
                }
                
                $config['upload_path'] = './assets/images/property/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('main_image')) {
                    $update_data['main_image'] = 'assets/images/property/' . $this->upload->data('file_name');
                }
            }

            // Handle location URL
            if ($this->input->post('location_url')) {
                $update_data['location_url'] = $this->input->post('location_url');
            } else {
                // If empty, set to null or empty string
                $update_data['location_url'] = '';
            }

            // Handle floorplan upload
            if (!empty($_FILES['floorplan']['name'])) {
                $config['upload_path'] = './assets/images/property/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('floorplan')) {
                    $update_data['floorplan'] = 'assets/images/property/' . $this->upload->data('file_name');
                }
            }

            // Handle nearby places with title and distance
            $nearby_titles = $this->input->post('nearby_title');
            $nearby_distances = $this->input->post('nearby_distance');
            $nearby_places = array();
            
            if ($nearby_titles && is_array($nearby_titles) && $nearby_distances && is_array($nearby_distances)) {
                foreach ($nearby_titles as $index => $title) {
                    $title = trim($title);
                    $distance = isset($nearby_distances[$index]) ? trim($nearby_distances[$index]) : '';
                    
                    if (!empty($title) && !empty($distance)) {
                        $nearby_places[] = array(
                            'title' => $title,
                            'distance' => $distance
                        );
                    }
                }
            }
            
            if (!empty($nearby_places)) {
                $update_data['nearby'] = json_encode($nearby_places);
            } else {
                $update_data['nearby'] = json_encode(array());
            }

            // Handle features (name + optional icon)
            $feature_names = $this->input->post('feature_name');
            $feature_icons = $this->input->post('feature_icon');
            $features_array = array();
            if ($feature_names && is_array($feature_names)) {
                foreach ($feature_names as $index => $name) {
                    $name = trim($name);
                    $icon = isset($feature_icons[$index]) ? trim($feature_icons[$index]) : '';
                    if (!empty($name)) {
                        $features_array[] = array('name' => $name, 'icon' => $icon);
                    }
                }
            }
            $update_data['features'] = json_encode($features_array);

            // Generate/update slug if name changed
            $this->load->helper('slug');
            if (!empty($update_data['name'])) {
                // Check if name actually changed
                if ($property->name != $update_data['name']) {
                    $update_data['slug'] = generate_unique_slug($update_data['name'], $id);
                }
            } elseif (empty($property->slug)) {
                // Generate slug if property doesn't have one
                $update_data['slug'] = generate_unique_slug($property->name, $id);
            }
            
            $this->Property_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Property updated successfully');
            redirect('admin/properties');
        }

        $data['cities'] = $this->City_model->get_all('active');
        $all_locations = $this->Location_model->get_all('active');
        $data['categories'] = $this->Category_model->get_all('active');
        $data['all_locations'] = $all_locations;
        
        $this->load->view('admin/header');
        $this->load->view('admin/properties/edit', $data);
        $this->load->view('admin/footer');
    }

    public function property_delete($id)
    {
        $this->check_login();
        $this->Property_model->delete($id);
        $this->session->set_flashdata('success', 'Property deleted successfully');
        redirect('admin/properties');
    }

    // Banners Management
    public function banners()
    {
        $this->check_login();
        // Get only active banners for admin table
        $data['banners'] = $this->Banner_model->get_all_for_admin();
        $this->load->view('admin/header');
        $this->load->view('admin/banners/list', $data);
        $this->load->view('admin/footer');
    }

    public function banner_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $data = array(
                'status' => $this->input->post('status') ?: 'inactive'
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/banner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                }
                
                if ($this->upload->do_upload('image')) {
                    $data['image'] = 'assets/images/banner/' . $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/banner_create');
                    return;
                }
            } else {
                $this->session->set_flashdata('error', 'Banner image is required');
                redirect('admin/banner_create');
                return;
            }

            $this->Banner_model->create($data);
            $this->session->set_flashdata('success', 'Banner created successfully');
            redirect('admin/banners');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/banners/create');
        $this->load->view('admin/footer');
    }

    public function banner_edit($id)
    {
        $this->check_login();
        $data['banner'] = $this->Banner_model->get_by_id($id);
        
        if (!$data['banner']) {
            show_404();
        }

        if ($this->input->post()) {
            $update_data = array(
                'title' => $this->input->post('title'),
                'link' => $this->input->post('link'),
                'status' => $this->input->post('status') ?: 'inactive'
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/banner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('image')) {
                    $update_data['image'] = 'assets/images/banner/' . $this->upload->data('file_name');
                }
            }

            $this->Banner_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Banner updated successfully');
            redirect('admin/banners');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/banners/edit', $data);
        $this->load->view('admin/footer');
    }

    public function banner_delete($id)
    {
        $this->check_login();
        $this->Banner_model->delete($id);
        $this->session->set_flashdata('success', 'Banner deleted successfully');
        redirect('admin/banners');
    }

    public function banner_toggle($id)
    {
        $this->check_login();
        $banner = $this->Banner_model->get_by_id($id);
        if ($banner) {
            $new_status = $banner->status == 'active' ? 'inactive' : 'active';
            $this->Banner_model->update($id, array('status' => $new_status));
            $message = $new_status == 'active' ? 'Banner activated successfully' : 'Banner deactivated and hidden from table';
            $this->session->set_flashdata('success', $message);
        }
        redirect('admin/banners');
    }

    // Enquiries Management
    public function enquiries()
    {
        $this->check_login();
        $data['enquiries'] = $this->Enquiry_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/enquiries/list', $data);
        $this->load->view('admin/footer');
    }

    public function enquiry_view($id)
    {
        $this->check_login();
        $data['enquiry'] = $this->Enquiry_model->get_by_id($id);
        
        if (!$data['enquiry']) {
            show_404();
        }

        // Mark as read
        if ($data['enquiry']->status == 'new') {
            $this->Enquiry_model->update($id, array('status' => 'read'));
        }

        $this->load->view('admin/header');
        $this->load->view('admin/enquiries/view', $data);
        $this->load->view('admin/footer');
    }

    public function enquiry_delete($id)
    {
        $this->check_login();
        $this->Enquiry_model->delete($id);
        $this->session->set_flashdata('success', 'Enquiry deleted successfully');
        redirect('admin/enquiries');
    }

    // Contacts Management
    public function contacts()
    {
        $this->check_login();
        $data['contacts'] = $this->Contact_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/contacts/list', $data);
        $this->load->view('admin/footer');
    }

    public function contact_view($id)
    {
        $this->check_login();
        $data['contact'] = $this->Contact_model->get_by_id($id);
        
        if (!$data['contact']) {
            show_404();
        }

        // Handle status update
        if ($this->input->post('status')) {
            $new_status = $this->input->post('status');
            if (in_array($new_status, array('new', 'read', 'replied'))) {
                $this->Contact_model->update($id, array('status' => $new_status));
                $this->session->set_flashdata('success', 'Contact status updated successfully');
                redirect('admin/contact_view/' . $id);
            }
        }

        // Mark as read if viewing for first time
        if ($data['contact']->status == 'new') {
            $this->Contact_model->update($id, array('status' => 'read'));
            // Refresh contact data after update
            $data['contact'] = $this->Contact_model->get_by_id($id);
        }

        $this->load->view('admin/header');
        $this->load->view('admin/contacts/view', $data);
        $this->load->view('admin/footer');
    }

    public function contact_delete($id)
    {
        $this->check_login();
        $this->Contact_model->delete($id);
        $this->session->set_flashdata('success', 'Contact deleted successfully');
        redirect('admin/contacts');
    }

    // Cities Management
    public function cities()
    {
        $this->check_login();
        $data['cities'] = $this->City_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/cities/list', $data);
        $this->load->view('admin/footer');
    }

    public function city_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/city/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/city_create');
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['image'] = 'assets/images/city/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/city_create');
                    return;
                }
            }

            $this->City_model->create($data);
            $this->session->set_flashdata('success', 'City created successfully');
            redirect('admin/cities');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/cities/create');
        $this->load->view('admin/footer');
    }

    public function city_edit($id)
    {
        $this->check_login();
        $data['city'] = $this->City_model->get_by_id($id);
        
        if (!$data['city']) {
            show_404();
        }

        if ($this->input->post()) {
            $update_data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/city/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/city_edit/' . $id);
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    // Delete old image if exists
                    if (!empty($data['city']->image) && file_exists('./' . $data['city']->image)) {
                        @unlink('./' . $data['city']->image);
                    }
                    $update_data['image'] = 'assets/images/city/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/city_edit/' . $id);
                    return;
                }
            }

            $this->City_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'City updated successfully');
            redirect('admin/cities');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/cities/edit', $data);
        $this->load->view('admin/footer');
    }

    public function city_delete($id)
    {
        $this->check_login();
        $this->City_model->delete($id);
        $this->session->set_flashdata('success', 'City deleted successfully');
        redirect('admin/cities');
    }

    // Locations Management
    public function locations()
    {
        $this->check_login();
        $data['locations'] = $this->Location_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/locations/list', $data);
        $this->load->view('admin/footer');
    }

    public function location_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            // Validate required fields
            $city_id = $this->input->post('city_id');
            $name = trim($this->input->post('name'));
            
            if (empty($city_id) || empty($name)) {
                $this->session->set_flashdata('error', 'City and Location Name are required fields.');
                redirect('admin/location_create');
                return;
            }

            $data = array(
                'city_id' => $city_id,
                'name' => $name,
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/location/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/location_create');
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['image'] = 'assets/images/location/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/location_create');
                    return;
                }
            }

            // Insert into database
            $insert_id = $this->Location_model->create($data);
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Location created successfully');
                redirect('admin/locations');
            } else {
                $this->session->set_flashdata('error', 'Failed to create location. Please try again.');
                redirect('admin/location_create');
            }
            return;
        }

        $data['cities'] = $this->City_model->get_all('active');
        $this->load->view('admin/header');
        $this->load->view('admin/locations/create', $data);
        $this->load->view('admin/footer');
    }

    public function location_edit($id)
    {
        $this->check_login();
        $data['location'] = $this->Location_model->get_by_id($id);
        
        if (!$data['location']) {
            show_404();
            return;
        }

        if ($this->input->post()) {
            // Validate required fields
            $city_id = $this->input->post('city_id');
            $name = trim($this->input->post('name'));
            
            if (empty($city_id) || empty($name)) {
                $this->session->set_flashdata('error', 'City and Location Name are required fields.');
                redirect('admin/location_edit/' . $id);
                return;
            }

            $update_data = array(
                'city_id' => $city_id,
                'name' => $name,
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/location/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/location_edit/' . $id);
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    // Delete old image if exists
                    if (!empty($data['location']->image) && file_exists('./' . $data['location']->image)) {
                        @unlink('./' . $data['location']->image);
                    }
                    $update_data['image'] = 'assets/images/location/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/location_edit/' . $id);
                    return;
                }
            } else {
                // Keep existing image if no new image uploaded
                if (!empty($this->input->post('existing_image'))) {
                    $update_data['image'] = $this->input->post('existing_image');
                }
            }

            // Update database
            $result = $this->Location_model->update($id, $update_data);
            if ($result) {
                $this->session->set_flashdata('success', 'Location updated successfully');
                redirect('admin/locations');
            } else {
                $this->session->set_flashdata('error', 'Failed to update location. Please try again.');
                redirect('admin/location_edit/' . $id);
            }
            return;
        }

        $data['cities'] = $this->City_model->get_all('active');
        $this->load->view('admin/header');
        $this->load->view('admin/locations/edit', $data);
        $this->load->view('admin/footer');
    }

    public function location_delete($id)
    {
        $this->check_login();
        $this->Location_model->delete($id);
        $this->session->set_flashdata('success', 'Location deleted successfully');
        redirect('admin/locations');
    }

    // Categories Management
    public function categories()
    {
        $this->check_login();
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/categories/list', $data);
        $this->load->view('admin/footer');
    }

    public function category_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $name = trim($this->input->post('category_name'));
            
            if (empty($name)) {
                $this->session->set_flashdata('error', 'Category Name is required.');
                redirect('admin/category_create');
                return;
            }

            $data = array(
                'category_name' => $name,
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/category_create');
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['image'] = 'assets/images/category/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/category_create');
                    return;
                }
            }

            $insert_id = $this->Category_model->create($data);
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Category created successfully');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to create category. Please try again.');
                redirect('admin/category_create');
            }
            return;
        }

        $this->load->view('admin/header');
        $this->load->view('admin/categories/create');
        $this->load->view('admin/footer');
    }

    public function category_edit($id)
    {
        $this->check_login();
        $data['category'] = $this->Category_model->get_by_id($id);
        
        if (!$data['category']) {
            show_404();
            return;
        }

        if ($this->input->post()) {
            $name = trim($this->input->post('category_name'));
            
            if (empty($name)) {
                $this->session->set_flashdata('error', 'Category Name is required.');
                redirect('admin/category_edit/' . $id);
                return;
            }

            $update_data = array(
                'category_name' => $name,
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/category_edit/' . $id);
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    // Delete old image if exists
                    if (!empty($data['category']->image) && file_exists('./' . $data['category']->image)) {
                        @unlink('./' . $data['category']->image);
                    }
                    $update_data['image'] = 'assets/images/category/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/category_edit/' . $id);
                    return;
                }
            } else {
                // Keep existing image if no new image uploaded
                if (!empty($this->input->post('existing_image'))) {
                    $update_data['image'] = $this->input->post('existing_image');
                }
            }

            $result = $this->Category_model->update($id, $update_data);
            if ($result) {
                $this->session->set_flashdata('success', 'Category updated successfully');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category. Please try again.');
                redirect('admin/category_edit/' . $id);
            }
            return;
        }

        $this->load->view('admin/header');
        $this->load->view('admin/categories/edit', $data);
        $this->load->view('admin/footer');
    }

    public function category_delete($id)
    {
        $this->check_login();
        $this->Category_model->delete($id);
        $this->session->set_flashdata('success', 'Category deleted successfully');
        redirect('admin/categories');
    }

    // Blog Management
    public function blogs()
    {
        $this->check_login();
        $data['blogs'] = $this->Blog_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/blogs/list', $data);
        $this->load->view('admin/footer');
    }

    public function blog_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'short_notes' => $this->input->post('short_notes'),
                'author' => $this->input->post('author'),
                'date' => $this->input->post('date') ?: date('Y-m-d'),
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle gallery upload - Multiple images
            $gallery_files = array();
            if (!empty($_FILES['gallery']['name'][0])) {
                $files = $_FILES['gallery'];
                $count = count($files['name']);
                
                // Ensure upload directory exists
                $upload_path = './assets/images/blog/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] == 0) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];
                        
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                        $config['max_size'] = 5120; // 5MB
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
                            $gallery_files[] = 'assets/images/blog/' . $upload_data['file_name'];
                        }
                    }
                }
            }
            
            if (!empty($gallery_files)) {
                $data['gallery'] = json_encode($gallery_files);
            } else {
                $data['gallery'] = json_encode(array());
            }

            $this->Blog_model->create($data);
            $this->session->set_flashdata('success', 'Blog created successfully');
            redirect('admin/blogs');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/blogs/create');
        $this->load->view('admin/footer');
    }

    public function blog_edit($id)
    {
        $this->check_login();
        $data['blog'] = $this->Blog_model->get_by_id($id);
        
        if (!$data['blog']) {
            show_404();
        }

        if ($this->input->post()) {
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'short_notes' => $this->input->post('short_notes'),
                'author' => $this->input->post('author'),
                'date' => $this->input->post('date') ?: date('Y-m-d'),
                'status' => $this->input->post('status') ?: 'active'
            );

            // Handle gallery upload - Multiple images (Edit mode)
            $gallery_files = array();
            
            // Keep existing gallery images
            $existing_gallery = $this->input->post('existing_gallery');
            if ($existing_gallery && is_array($existing_gallery)) {
                $gallery_files = $existing_gallery;
            } else {
                // If no existing gallery posted, keep current gallery
                if ($data['blog']->gallery) {
                    $gallery_files = json_decode($data['blog']->gallery, true) ?: array();
                }
            }
            
            // Add new gallery images
            if (!empty($_FILES['gallery']['name'][0])) {
                $files = $_FILES['gallery'];
                $count = count($files['name']);
                
                // Ensure upload directory exists
                $upload_path = './assets/images/blog/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] == 0) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];
                        
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                        $config['max_size'] = 5120; // 5MB
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
                            $gallery_files[] = 'assets/images/blog/' . $upload_data['file_name'];
                        }
                    }
                }
            }
            
            // Delete removed gallery images from server
            if ($data['blog']->gallery) {
                $old_gallery = json_decode($data['blog']->gallery, true) ?: array();
                foreach ($old_gallery as $old_img) {
                    // If image was removed (not in new gallery), delete the file
                    if (!in_array($old_img, $gallery_files) && !empty($old_img) && file_exists('./' . $old_img)) {
                        @unlink('./' . $old_img);
                    }
                }
            }
            
            // Store gallery as JSON array in database (even if empty, to clear gallery)
            $update_data['gallery'] = !empty($gallery_files) ? json_encode($gallery_files) : json_encode(array());

            $this->Blog_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Blog updated successfully');
            redirect('admin/blogs');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/blogs/edit', $data);
        $this->load->view('admin/footer');
    }

    public function blog_delete($id)
    {
        $this->check_login();
        $this->Blog_model->delete($id);
        $this->session->set_flashdata('success', 'Blog deleted successfully');
        redirect('admin/blogs');
    }

    // ==================== OFFER BANNERS MANAGEMENT ====================

    public function offer_banners()
    {
        $this->check_login();
        $data['offer_banners'] = $this->Offer_banner_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/offer_banners/list', $data);
        $this->load->view('admin/footer');
    }

    public function offer_banner_create()
    {
        $this->check_login();
        
        if ($this->input->post()) {
            $data = array(
                'title' => $this->input->post('title') ?: null,
                'link' => $this->input->post('link') ?: null,
                'status' => $this->input->post('status') ?: 'inactive'
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/offer_banner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/offer_banner_create');
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['image'] = 'assets/images/offer_banner/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/offer_banner_create');
                    return;
                }
            } else {
                $this->session->set_flashdata('error', 'Offer banner image is required');
                redirect('admin/offer_banner_create');
                return;
            }

            $insert_id = $this->Offer_banner_model->create($data);
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Offer banner created successfully');
                redirect('admin/offer_banners');
            } else {
                $this->session->set_flashdata('error', 'Failed to create offer banner. Please try again.');
                redirect('admin/offer_banner_create');
            }
            return;
        }

        $this->load->view('admin/header');
        $this->load->view('admin/offer_banners/create');
        $this->load->view('admin/footer');
    }

    public function offer_banner_edit($id)
    {
        $this->check_login();
        $data['offer_banner'] = $this->Offer_banner_model->get_by_id($id);
        
        if (!$data['offer_banner']) {
            show_404();
            return;
        }

        if ($this->input->post()) {
            $update_data = array(
                'title' => $this->input->post('title') ?: null,
                'link' => $this->input->post('link') ?: null,
                'status' => $this->input->post('status') ?: 'inactive'
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/offer_banner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    if (!mkdir($config['upload_path'], 0777, true)) {
                        $this->session->set_flashdata('error', 'Failed to create upload directory.');
                        redirect('admin/offer_banner_edit/' . $id);
                        return;
                    }
                }
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    // Delete old image if exists
                    if (!empty($data['offer_banner']->image) && file_exists('./' . $data['offer_banner']->image)) {
                        @unlink('./' . $data['offer_banner']->image);
                    }
                    $update_data['image'] = 'assets/images/offer_banner/' . $this->upload->data('file_name');
                } else {
                    $error_msg = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
                    redirect('admin/offer_banner_edit/' . $id);
                    return;
                }
            } else {
                // Keep existing image if no new image uploaded
                if (!empty($this->input->post('existing_image'))) {
                    $update_data['image'] = $this->input->post('existing_image');
                }
            }

            $result = $this->Offer_banner_model->update($id, $update_data);
            if ($result) {
                $this->session->set_flashdata('success', 'Offer banner updated successfully');
                redirect('admin/offer_banners');
            } else {
                $this->session->set_flashdata('error', 'Failed to update offer banner. Please try again.');
                redirect('admin/offer_banner_edit/' . $id);
            }
            return;
        }

        $this->load->view('admin/header');
        $this->load->view('admin/offer_banners/edit', $data);
        $this->load->view('admin/footer');
    }

    public function offer_banner_delete($id)
    {
        $this->check_login();
        $offer_banner = $this->Offer_banner_model->get_by_id($id);

        if ($offer_banner) {
            if (!empty($offer_banner->image) && file_exists('./' . $offer_banner->image)) {
                @unlink('./' . $offer_banner->image);
            }
            $this->Offer_banner_model->delete($id);
            $this->session->set_flashdata('success', 'Offer banner deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Offer banner not found');
        }
        redirect('admin/offer_banners');
    }

    // Testimonials Management
    public function testimonials()
    {
        $this->check_login();
        $data['testimonials'] = $this->Testimonial_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/testimonials/list', $data);
        $this->load->view('admin/footer');
    }

    public function testimonial_create()
    {
        $this->check_login();

        if ($this->input->post()) {
            $data = array(
                'name'        => trim($this->input->post('name')),
                'designation' => trim($this->input->post('designation')),
                'review'      => trim($this->input->post('review')),
                'status'      => $this->input->post('status') ?: 'active',
                'sort_order'  => (int)$this->input->post('sort_order'),
            );

            if (!empty($_FILES['author_image']['name'])) {
                $upload_path = './assets/images/testimonials/';
                if (!is_dir($upload_path)) { mkdir($upload_path, 0777, true); }
                $config = array(
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'gif|jpg|png|jpeg|webp',
                    'max_size'      => 2048,
                    'encrypt_name'  => TRUE,
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('author_image')) {
                    $data['author_image'] = 'assets/images/testimonials/' . $this->upload->data('file_name');
                }
            }

            $this->Testimonial_model->create($data);
            $this->session->set_flashdata('success', 'Testimonial added successfully');
            redirect('admin/testimonials');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/testimonials/create');
        $this->load->view('admin/footer');
    }

    public function testimonial_edit($id)
    {
        $this->check_login();
        $data['testimonial'] = $this->Testimonial_model->get_by_id($id);
        if (!$data['testimonial']) { show_404(); }

        if ($this->input->post()) {
            $update = array(
                'name'        => trim($this->input->post('name')),
                'designation' => trim($this->input->post('designation')),
                'review'      => trim($this->input->post('review')),
                'status'      => $this->input->post('status') ?: 'active',
                'sort_order'  => (int)$this->input->post('sort_order'),
            );

            if (!empty($_FILES['author_image']['name'])) {
                $upload_path = './assets/images/testimonials/';
                if (!is_dir($upload_path)) { mkdir($upload_path, 0777, true); }
                $config = array(
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'gif|jpg|png|jpeg|webp',
                    'max_size'      => 2048,
                    'encrypt_name'  => TRUE,
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('author_image')) {
                    $update['author_image'] = 'assets/images/testimonials/' . $this->upload->data('file_name');
                }
            } else {
                $existing = $this->input->post('existing_image');
                if ($existing) { $update['author_image'] = $existing; }
            }

            $this->Testimonial_model->update($id, $update);
            $this->session->set_flashdata('success', 'Testimonial updated successfully');
            redirect('admin/testimonials');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/testimonials/edit', $data);
        $this->load->view('admin/footer');
    }

    public function testimonial_delete($id)
    {
        $this->check_login();
        $t = $this->Testimonial_model->get_by_id($id);
        if ($t && !empty($t->author_image) && file_exists('./' . $t->author_image)) {
            @unlink('./' . $t->author_image);
        }
        $this->Testimonial_model->delete($id);
        $this->session->set_flashdata('success', 'Testimonial deleted successfully');
        redirect('admin/testimonials');
    }

    // Amenities Management (file system only, no DB)
    public function amenities()
    {
        $this->check_login();
        $logos_path = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'logos' . DIRECTORY_SEPARATOR;
        $files = array();
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        if (is_dir($logos_path)) {
            $items = scandir($logos_path);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed) && is_file($logos_path . $item)) {
                    $files[] = array(
                        'name' => $item,
                        'path' => 'assets/logos/' . $item,
                    );
                }
            }
        }
        $data['logos'] = $files;
        $this->load->view('admin/header');
        $this->load->view('admin/amenities/list', $data);
        $this->load->view('admin/footer');
    }

    public function amenity_upload()
    {
        $this->check_login();
        if (!empty($_FILES['logo']['name'])) {
            $upload_path = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'logos' . DIRECTORY_SEPARATOR;
            if (!is_dir($upload_path)) { mkdir($upload_path, 0777, true); }
            $config = array(
                'upload_path'   => $upload_path,
                'allowed_types' => 'gif|jpg|png|jpeg|webp',
                'max_size'      => 2048,
                'encrypt_name'  => FALSE,
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('logo')) {
                $this->session->set_flashdata('success', 'Amenity logo uploaded successfully');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            }
        }
        redirect('admin/amenities');
    }

    public function amenity_delete()
    {
        $this->check_login();
        $filename = $this->input->post('filename');
        if ($filename) {
            $filename = basename($filename);
            $file_path = FCPATH . 'assets/logos/' . $filename;
            if (file_exists($file_path)) {
                @unlink($file_path);
                $this->session->set_flashdata('success', 'Amenity logo deleted successfully');
            }
        }
        redirect('admin/amenities');
    }

    // SEO Management
    public function seo()
    {
        $this->check_login();
        $data['pages'] = $this->Seo_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/seo/list', $data);
        $this->load->view('admin/footer');
    }

    public function seo_edit($id)
    {
        $this->check_login();
        $data['seo'] = $this->Seo_model->get_by_id($id);

        if (!$data['seo']) {
            show_404();
        }

        if ($this->input->post()) {
            $update = array(
                'title'       => $this->input->post('title')       ?: null,
                'keywords'    => $this->input->post('keywords')    ?: null,
                'description' => $this->input->post('description') ?: null,
            );
            $this->Seo_model->update($id, $update);
            $this->session->set_flashdata('success', 'SEO settings saved for "' . $data['seo']->page_label . '"');
            redirect('admin/seo');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/seo/edit', $data);
        $this->load->view('admin/footer');
    }
}

