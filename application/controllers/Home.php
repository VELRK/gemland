<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Property_model');
        $this->load->model('Banner_model');
        $this->load->helper('property');
    }

    public function property_detail($slug_or_id = null) {
        if (!$slug_or_id) {
            show_404();
            return;
        }
        
        // Load slug helper
        $this->load->helper('slug');
        
        // Try to get property by slug first, then by ID (for backward compatibility)
        if (is_numeric($slug_or_id)) {
            $property = $this->Property_model->get_by_id($slug_or_id);
        } else {
            $property = $this->Property_model->get_by_slug($slug_or_id);
            // If not found by slug and it's numeric-like, try ID
            if (!$property && is_numeric($slug_or_id)) {
                $property = $this->Property_model->get_by_id($slug_or_id);
            }
        }
        
        if (!$property || $property->status != 'active') {
            show_404();
            return;
        }
        
        // If property has no slug, generate one
        if (empty($property->slug)) {
            $slug = generate_unique_slug($property->name, $property->id);
            $this->Property_model->update($property->id, array('slug' => $slug));
            $property->slug = $slug;
        }
        
        // Process gallery images
        $gallery_images = array();
        if (!empty($property->gallery)) {
            $gallery_array = json_decode($property->gallery, true);
            if (is_array($gallery_array)) {
                // Filter out empty values and clean paths
                foreach ($gallery_array as $img) {
                    if (!empty($img) && is_string($img)) {
                        // Remove leading/trailing slashes and whitespace
                        $img = trim($img);
                        $img = ltrim($img, '/');
                        if (!empty($img)) {
                            $gallery_images[] = $img;
                        }
                    }
                }
            }
        }
        
        // Clean main_image path if exists
        if (!empty($property->main_image)) {
            $property->main_image = trim($property->main_image);
            $property->main_image = ltrim($property->main_image, '/');
        }
        
        // If no gallery images, use main_image
        if (empty($gallery_images) && !empty($property->main_image)) {
            $gallery_images[] = $property->main_image;
        }
        
        // Process features — normalise old plain-string format and new {name,icon} format
        $features = array();
        if (!empty($property->features)) {
            $features_raw = json_decode($property->features, true);
            if (is_array($features_raw)) {
                foreach ($features_raw as $feat) {
                    if (is_string($feat) && !empty(trim($feat))) {
                        $features[] = array('name' => trim($feat), 'icon' => '');
                    } elseif (is_array($feat) && !empty($feat['name'])) {
                        $features[] = $feat;
                    }
                }
            }
        }

        // Process nearby places
        $nearby_places = array();
        if (!empty($property->nearby)) {
            $nearby_array = json_decode($property->nearby, true);
            if (is_array($nearby_array) && !empty($nearby_array)) {
                // Filter out empty entries
                foreach ($nearby_array as $place) {
                    if (is_array($place)) {
                        // New format: array with title and distance
                        if (!empty($place['title']) || !empty($place['distance'])) {
                            $nearby_places[] = $place;
                        }
                    } elseif (is_string($place) && !empty(trim($place))) {
                        // Old format: just a string
                        $nearby_places[] = trim($place);
                    }
                }
            } elseif ($nearby_array === null && is_string($property->nearby) && !empty(trim($property->nearby))) {
                // If it's a plain string (not JSON), use it directly
                $nearby_places[] = trim($property->nearby);
            }
        }
        
        // Fetch latest properties for sidebar
        $data['latest_properties'] = $this->Property_model->get_latest_for_sale(4);
        
        $data['page_title'] = htmlspecialchars($property->name);
        $data['page'] = 'property-detail';
        $data['property'] = $property;
        $data['gallery_images'] = $gallery_images;
        $data['features'] = $features;
        $data['nearby_places'] = $nearby_places;
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/property-detail-v1', $data);
        $this->load->view('frontend/footer');
    }

    public function index() {
        $data['page_title'] = 'Home';
        $data['page'] = 'home';
        
        // Load models
        $this->load->model('Category_model');
        $this->load->model('City_model');
        $this->load->model('Location_model');
        
        // Load data from database
        $data['categories'] = $this->Category_model->get_all('active');
        $data['cities'] = $this->City_model->get_all('active');
        $data['locations'] = $this->Location_model->get_all('active');
        // Load locations with active property counts for property location section
        $data['locations_with_counts'] = $this->Location_model->get_all_with_property_count('active');
        
        // Load featured properties (is_featured = 1 and status = 'active')
        $data['featured_properties'] = $this->Property_model->get_featured_properties(6);

        // Load testimonials
        $this->load->model('Testimonial_model');
        $data['testimonials'] = $this->Testimonial_model->get_active();
        
        // Load featured items for "Our Best Featured Item" section (vertical slider)
        // Include both featured and latest properties
        $data['featured_items'] = $this->Property_model->get_featured_and_latest_properties(10);
        
        // Load active banners for home page
        $data['banners'] = $this->Banner_model->get_active();
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/home', $data);
        $this->load->view('frontend/footer');
    }

    public function privacy_policy() {
        $data['page_title'] = 'Privacy Policy - Gem Housing';
        $data['page'] = 'privacy-policy';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('privacy_policy');
        $this->load->view('frontend/footer');
    }

    public function testimonials() {
        $data['page_title'] = 'Testimonials - Gem Housing';
        $data['page'] = 'testimonials';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('testimonials');
        $this->load->view('frontend/footer');
    }

    public function terms_conditions() {
        $data['page_title'] = 'Terms & Conditions - Gem Housing';
        $data['page'] = 'terms-conditions';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('terms_conditions');
        $this->load->view('frontend/footer');
    }
}
