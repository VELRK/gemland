<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Property_model');
        $this->load->model('Category_model');
        $this->load->model('City_model');
        $this->load->model('Location_model');
        $this->load->helper('property');
    }

    public function index() {
        $data['page_title'] = 'Property Listing';
        $data['page'] = 'listing';
        
        // Load filter options
        $data['categories'] = $this->Category_model->get_all('active');
        $data['cities'] = $this->City_model->get_all('active');
        $data['locations'] = $this->Location_model->get_all('active');
        
        // Get all unique amenities from properties
        $data['amenities'] = $this->Property_model->get_all_amenities();
        
        // Get total count of active properties
        $data['total_properties'] = $this->Property_model->count_all('active');
        
        // Get latest properties (limit 4 for sidebar)
        $data['latest_properties'] = $this->Property_model->get_latest_for_sale(4);
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/listing', $data);
        $this->load->view('frontend/footer');
    }

    public function search() {
        // Set JSON header
        $this->output->set_content_type('application/json');
        
        try {
            $filters = array();
            
            // Get filter parameters
            if ($this->input->get('category') && !empty($this->input->get('category'))) {
                $filters['category'] = $this->input->get('category');
            }
            if ($this->input->get('city') && !empty($this->input->get('city'))) {
                $filters['city'] = $this->input->get('city');
            }
            if ($this->input->get('location') && !empty($this->input->get('location'))) {
                $filters['location'] = $this->input->get('location');
            }
            // Price range filter removed
            // Keep min_price and max_price for backward compatibility
            if ($this->input->get('min_price') && !empty($this->input->get('min_price'))) {
                $filters['min_price'] = $this->input->get('min_price');
            }
            if ($this->input->get('max_price') && !empty($this->input->get('max_price'))) {
                $filters['max_price'] = $this->input->get('max_price');
            }
            if ($this->input->get('sort_by') && !empty($this->input->get('sort_by'))) {
                $filters['sort_by'] = $this->input->get('sort_by');
            }
            if ($this->input->get('property_type') && !empty($this->input->get('property_type'))) {
                $filters['type'] = $this->input->get('property_type');
            }
            
            // Get amenities filter (can be array or single value)
            if ($this->input->get('amenities')) {
                $amenities = $this->input->get('amenities');
                if (is_array($amenities)) {
                    $amenities = array_filter($amenities); // Remove empty values
                    if (!empty($amenities)) {
                        $filters['amenities'] = $amenities;
                    }
                } elseif (!empty($amenities)) {
                    $filters['amenities'] = array($amenities);
                }
            }
            
            // Get limit
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : null;
            
            // Get properties
            $properties = $this->Property_model->search($filters);
            
            // Apply limit if specified
            if ($limit && $limit > 0) {
                $properties = array_slice($properties, 0, $limit);
            }
            
            // Load slug helper
            $this->load->helper('slug');
            
            // Format properties for JSON response
            $formatted_properties = array();
            foreach ($properties as $property) {
                // Generate slug if not exists
                if (empty($property->slug)) {
                    $slug = generate_unique_slug($property->name, $property->id);
                    $this->Property_model->update($property->id, array('slug' => $slug));
                    $property->slug = $slug;
                }
                
                $formatted_properties[] = array(
                    'id' => $property->id,
                    'slug' => isset($property->slug) ? $property->slug : '',
                    'title' => isset($property->title) ? $property->title : (isset($property->name) ? $property->name : ''),
                    'category' => isset($property->category) ? $property->category : '',
                    'city' => isset($property->city) ? $property->city : '',
                    'location' => isset($property->location) ? $property->location : '',
                    'price' => isset($property->price) ? floatval($property->price) : 0,
                    'price_formatted' => isset($property->price) ? format_price_indian($property->price) : '₹0',
                    'main_image' => isset($property->main_image) ? base_url($property->main_image) : base_url('images/logo.svg'),
                    'is_featured' => isset($property->is_featured) ? $property->is_featured : 0,
                    'area' => isset($property->area) ? $property->area : '',
                    'bedrooms' => isset($property->bedrooms) ? $property->bedrooms : '',
                    'bathrooms' => isset($property->bathrooms) ? $property->bathrooms : '',
                    'type' => isset($property->type) ? $property->type : 'For Sale',
                    'process' => isset($property->process) ? $property->process : 'Upcoming',
                    'created_at' => isset($property->created_at) ? $property->created_at : '',
                    'description' => isset($property->description) ? $property->description : '',
                    'total_plot' => isset($property->total_plot) ? $property->total_plot : '',
                    'available_size' => isset($property->available_size) ? $property->available_size : ''
                );
            }
            
            // Get total count for current filters
            $total_count = count($this->Property_model->search($filters));
            
            $this->output->set_output(json_encode(array(
                'success' => true,
                'properties' => $formatted_properties,
                'total' => $total_count,
                'showing' => count($formatted_properties)
            )));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(array(
                'success' => false,
                'error' => $e->getMessage(),
                'properties' => array(),
                'total' => 0,
                'showing' => 0
            )));
        }
    }
}
