<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_mobile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('whatsapp_library');
        
        // Load all models
        $this->load->model('Property_model');
        $this->load->model('Blog_model');
        $this->load->model('Category_model');
        $this->load->model('City_model');
        $this->load->model('Location_model');
        $this->load->model('Banner_model');
        $this->load->model('Offer_banner_model');
        $this->load->model('Contact_model');
        $this->load->model('Enquiry_model');
        $this->load->model('User_model');
        
        // Set JSON output
        $this->output->set_content_type('application/json');
    }

    /**
     * Send JSON response
     */
    private function _send_response($success, $data = null, $message = '', $errors = null)
    {
        $response = array(
            'success' => $success,
            'message' => $message
        );
        
        if ($success) {
            if ($data !== null) {
                $response['data'] = $data;
            }
        } else {
            if ($errors !== null) {
                $response['errors'] = $errors;
            }
        }
        
        $this->output->set_output(json_encode($response));
    }

    /**
     * Get input data - handles both JSON and form data
     */
    private function _get_input($key = null)
    {
        // Check if request is JSON
        $content_type = $this->input->server('CONTENT_TYPE');
        if (strpos($content_type, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if ($key === null) {
                return $data;
            }
            
            return isset($data[$key]) ? $data[$key] : null;
        }
        
        // Fallback to regular POST/GET
        if ($key === null) {
            return array_merge($this->input->post(), $this->input->get());
        }
        
        $value = $this->input->post($key);
        if ($value === null) {
            $value = $this->input->get($key);
        }
        
        return $value;
    }

    /**
     * Format property object to array with full URLs
     */
    private function _format_property($property)
    {
        $main_image = !empty($property->main_image) ? base_url($property->main_image) : base_url('images/logo.svg');
        
        $gallery = array();
        if (!empty($property->gallery)) {
            $gallery_data = json_decode($property->gallery, true);
            if (is_array($gallery_data)) {
                foreach ($gallery_data as $img) {
                    $gallery[] = base_url($img);
                }
            }
        }
        
        // Parse nearby places
        $nearby = array();
        if (!empty($property->nearby)) {
            $nearby_data = json_decode($property->nearby, true);
            if (is_array($nearby_data)) {
                $nearby = $nearby_data;
            }
        }
        
        // Parse features
        $features = array();
        if (!empty($property->features)) {
            $features_data = json_decode($property->features, true);
            if (is_array($features_data)) {
                $features = $features_data;
            }
        }
        
        return array(
            'id' => (int)$property->id,
            'name' => $property->name,
            'category' => $property->category,
            'location' => $property->location,
            'location_url' => isset($property->location_url) && !empty($property->location_url) ? $property->location_url : null,
            'city' => $property->city,
            'price' => (float)$property->price,
            'formatted_price' => number_format($property->price, 0),
            'description' => $property->description,
            'main_image' => $main_image,
            'gallery' => $gallery,
            'locationimg' => !empty($property->locationimg) ? base_url($property->locationimg) : null,
            'floorplan' => !empty($property->floorplan) ? base_url($property->floorplan) : null,
            'video' => isset($property->video) && !empty($property->video) ? $property->video : null,
            'type' => isset($property->type) ? $property->type : null,
            'is_featured' => isset($property->is_featured) ? (bool)$property->is_featured : false,
            'is_latest' => isset($property->is_latest) ? (bool)$property->is_latest : false,
            'rating' => isset($property->rating) && $property->rating > 0 ? (float)$property->rating : 5.0,
            'nearby' => $nearby,
            'features' => $features,
            'status' => $property->status,
            'created_at' => isset($property->created_at) ? $property->created_at : null,
            'updated_at' => isset($property->updated_at) ? $property->updated_at : null
        );
    }

    /**
     * Format blog object to array with full URLs
     */
    private function _format_blog($blog)
    {
        // Get image from gallery if available, otherwise use image field
        $image = null;
        if (!empty($blog->gallery)) {
            $gallery = json_decode($blog->gallery, true);
            if (is_array($gallery) && !empty($gallery[0])) {
                $image = base_url($gallery[0]);
            }
        }
        if (!$image && !empty($blog->image)) {
            $image = base_url($blog->image);
        }
        
        // Safely get content - use description if content doesn't exist
        $content = '';
        if (property_exists($blog, 'content') && !empty($blog->content)) {
            $content = $blog->content;
        } elseif (property_exists($blog, 'description') && !empty($blog->description)) {
            $content = $blog->description;
        }
        
        return array(
            'id' => (int)$blog->id,
            'name' => property_exists($blog, 'name') ? $blog->name : '',
            'description' => property_exists($blog, 'description') ? $blog->description : '',
            'content' => $content,
            'short_notes' => property_exists($blog, 'short_notes') ? $blog->short_notes : null,
            'image' => $image,
            'gallery' => property_exists($blog, 'gallery') ? $blog->gallery : null,
            'author' => property_exists($blog, 'author') ? $blog->author : null,
            'date' => property_exists($blog, 'date') ? $blog->date : null,
            'status' => property_exists($blog, 'status') ? $blog->status : 'active',
            'created_at' => property_exists($blog, 'created_at') ? $blog->created_at : null,
            'updated_at' => property_exists($blog, 'updated_at') ? $blog->updated_at : null
        );
    }

    // ==================== PROPERTIES API ====================

    /**
     * Get all properties
     * GET /api/mobile/properties
     * Query params: status (optional), limit (optional), offset (optional)
     */
    public function properties()
    {
        try {
            $status = $this->input->get('status') ?: 'active';
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : null;
            $offset = $this->input->get('offset') ? (int)$this->input->get('offset') : 0;
            
            $properties = $this->Property_model->get_all($status);
            
            if ($limit) {
                $properties = array_slice($properties, $offset, $limit);
            }
            
            $formatted_properties = array();
            foreach ($properties as $property) {
                $formatted_properties[] = $this->_format_property($property);
            }
            
            $this->_send_response(true, array(
                'properties' => $formatted_properties,
                'total' => count($this->Property_model->get_all($status)),
                'limit' => $limit,
                'offset' => $offset
            ), 'Properties retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving properties', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get property by ID
     * GET /api/mobile/properties/{id}
     */
    public function property($id = null)
    {
        try {
            if (!$id) {
                $id = $this->uri->segment(4);
            }
            
            if (!$id) {
                $this->_send_response(false, null, 'Property ID is required', array('id' => 'Property ID is required'));
                return;
            }
            
            $property = $this->Property_model->get_by_id($id);
            
            if (!$property) {
                $this->_send_response(false, null, 'Property not found', array('id' => 'Property not found'));
                return;
            }
            
            $this->_send_response(true, $this->_format_property($property), 'Property retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving property', array('message' => $e->getMessage()));
        }
    }

    /**
     * Search properties
     * POST /api/mobile/properties/search
     * Body: category, city, location, min_price, max_price, is_featured, is_latest, type, sort_by
     */
    public function search_properties()
    {
        try {
            $filters = array();
            
            if ($this->_get_input('category')) {
                $filters['category'] = $this->_get_input('category');
            }
            if ($this->_get_input('city')) {
                $filters['city'] = $this->_get_input('city');
            }
            if ($this->_get_input('location')) {
                $filters['location'] = $this->_get_input('location');
            }
            if ($this->_get_input('min_price')) {
                $filters['min_price'] = $this->_get_input('min_price');
            }
            if ($this->_get_input('max_price')) {
                $filters['max_price'] = $this->_get_input('max_price');
            }
            if ($this->_get_input('is_featured')) {
                $filters['is_featured'] = $this->_get_input('is_featured');
            }
            if ($this->_get_input('is_latest')) {
                $filters['is_latest'] = $this->_get_input('is_latest');
            }
            if ($this->_get_input('type')) {
                $filters['type'] = $this->_get_input('type');
            }
            if ($this->_get_input('sort_by')) {
                $filters['sort_by'] = $this->_get_input('sort_by');
            }
            
            $properties = $this->Property_model->search($filters);
            
            $formatted_properties = array();
            foreach ($properties as $property) {
                $formatted_properties[] = $this->_format_property($property);
            }
            
            $this->_send_response(true, array(
                'properties' => $formatted_properties,
                'total' => count($formatted_properties),
                'filters' => $filters
            ), 'Properties search completed successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error searching properties', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get featured properties
     * GET /api/mobile/properties/featured?limit=6
     */
    public function featured_properties()
    {
        try {
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 6;
            
            $properties = $this->Property_model->get_featured_properties($limit);
            
            $formatted_properties = array();
            foreach ($properties as $property) {
                $formatted_properties[] = $this->_format_property($property);
            }
            
            $this->_send_response(true, array(
                'properties' => $formatted_properties,
                'total' => count($formatted_properties)
            ), 'Featured properties retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving featured properties', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get latest properties
     * GET /api/mobile/properties/latest?limit=6
     */
    public function latest_properties()
    {
        try {
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 6;
            
            $properties = $this->Property_model->get_latest_for_sale($limit);
            
            $formatted_properties = array();
            foreach ($properties as $property) {
                $formatted_properties[] = $this->_format_property($property);
            }
            
            $this->_send_response(true, array(
                'properties' => $formatted_properties,
                'total' => count($formatted_properties)
            ), 'Latest properties retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving latest properties', array('message' => $e->getMessage()));
        }
    }

    // ==================== BLOGS API ====================

    /**
     * Get all blogs
     * GET /api/mobile/blogs?status=active&limit=10&offset=0
     */
    public function blogs()
    {
        try {
            $status = $this->input->get('status') ?: 'active';
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : null;
            $offset = $this->input->get('offset') ? (int)$this->input->get('offset') : 0;
            
            $blogs = $this->Blog_model->get_all($status);
            
            if ($limit) {
                $blogs = array_slice($blogs, $offset, $limit);
            }
            
            $formatted_blogs = array();
            foreach ($blogs as $blog) {
                $formatted_blogs[] = $this->_format_blog($blog);
            }
            
            $this->_send_response(true, array(
                'blogs' => $formatted_blogs,
                'total' => count($this->Blog_model->get_all($status)),
                'limit' => $limit,
                'offset' => $offset
            ), 'Blogs retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving blogs', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get blog by ID
     * GET /api/mobile/blogs/{id}
     */
    public function blog($id = null)
    {
        try {
            if (!$id) {
                $id = $this->uri->segment(4);
            }
            
            if (!$id) {
                $this->_send_response(false, null, 'Blog ID is required', array('id' => 'Blog ID is required'));
                return;
            }
            
            $blog = $this->Blog_model->get_by_id($id);
            
            if (!$blog || $blog->status != 'active') {
                $this->_send_response(false, null, 'Blog not found', array('id' => 'Blog not found'));
                return;
            }
            
            $this->_send_response(true, $this->_format_blog($blog), 'Blog retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving blog', array('message' => $e->getMessage()));
        }
    }

    // ==================== CATEGORIES API ====================

    /**
     * Get all categories
     * GET /api/mobile/categories?status=active&with_count=true
     */
    public function categories()
    {
        try {
            $status = $this->input->get('status') ?: 'active';
            $with_count = $this->input->get('with_count') == 'true';
            
            if ($with_count) {
                $categories = $this->Category_model->get_all_with_property_count($status);
            } else {
                $categories = $this->Category_model->get_all($status);
            }
            
            $formatted_categories = array();
            foreach ($categories as $category) {
                $cat_data = array(
                    'id' => (int)$category->id,
                    'category_name' => $category->category_name,
                    'status' => $category->status,
                    'created_at' => isset($category->created_at) ? $category->created_at : null,
                    'image' => isset($category->image) && !empty($category->image) ? base_url($category->image) : null
                );
                
                if ($with_count && isset($category->property_count)) {
                    $cat_data['property_count'] = (int)$category->property_count;
                }
                
                $formatted_categories[] = $cat_data;
            }
            
            $this->_send_response(true, array(
                'categories' => $formatted_categories,
                'total' => count($formatted_categories)
            ), 'Categories retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving categories', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get category by ID
     * GET /api/mobile/categories/{id}
     */
    public function category($id = null)
    {
        try {
            if (!$id) {
                $id = $this->uri->segment(4);
            }
            
            if (!$id) {
                $this->_send_response(false, null, 'Category ID is required', array('id' => 'Category ID is required'));
                return;
            }
            
            $category = $this->Category_model->get_by_id($id);
            
            if (!$category) {
                $this->_send_response(false, null, 'Category not found', array('id' => 'Category not found'));
                return;
            }
            
            $cat_data = array(
                'id' => (int)$category->id,
                'category_name' => $category->category_name,
                'status' => $category->status,
                'created_at' => isset($category->created_at) ? $category->created_at : null,
                'image' => isset($category->image) && !empty($category->image) ? base_url($category->image) : null
            );
            
            $this->_send_response(true, $cat_data, 'Category retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving category', array('message' => $e->getMessage()));
        }
    }

    // ==================== CITIES API ====================

    /**
     * Get all cities
     * GET /api/mobile/cities?status=active
     */
    public function cities()
    {
        try {
            $status = $this->input->get('status') ?: 'active';
            
            $cities = $this->City_model->get_all($status);
            
            $formatted_cities = array();
            foreach ($cities as $city) {
                $city_data = array(
                    'id' => (int)$city->id,
                    'name' => $city->name,
                    'status' => $city->status,
                    'created_at' => isset($city->created_at) ? $city->created_at : null,
                    'image' => isset($city->image) && !empty($city->image) ? base_url($city->image) : null
                );
                
                $formatted_cities[] = $city_data;
            }
            
            $this->_send_response(true, array(
                'cities' => $formatted_cities,
                'total' => count($formatted_cities)
            ), 'Cities retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving cities', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get city by ID
     * GET /api/mobile/cities/{id}
     */
    public function city($id = null)
    {
        try {
            if (!$id) {
                $id = $this->uri->segment(4);
            }
            
            if (!$id) {
                $this->_send_response(false, null, 'City ID is required', array('id' => 'City ID is required'));
                return;
            }
            
            $city = $this->City_model->get_by_id($id);
            
            if (!$city) {
                $this->_send_response(false, null, 'City not found', array('id' => 'City not found'));
                return;
            }
            
            $city_data = array(
                'id' => (int)$city->id,
                'name' => $city->name,
                'status' => $city->status,
                'created_at' => isset($city->created_at) ? $city->created_at : null,
                'image' => isset($city->image) && !empty($city->image) ? base_url($city->image) : null
            );
            
            $this->_send_response(true, $city_data, 'City retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving city', array('message' => $e->getMessage()));
        }
    }

    // ==================== LOCATIONS API ====================

    /**
     * Get all locations
     * GET /api/mobile/locations?status=active&city_id=1&with_count=true
     */
    public function locations()
    {
        try {
            $status = $this->input->get('status') ?: 'active';
            $city_id = $this->input->get('city_id') ? (int)$this->input->get('city_id') : null;
            $with_count = $this->input->get('with_count') == 'true';
            
            if ($with_count) {
                $locations = $this->Location_model->get_all_with_property_count($status);
            } else {
                $locations = $this->Location_model->get_all($status, $city_id);
            }
            
            $formatted_locations = array();
            foreach ($locations as $location) {
                $loc_data = array(
                    'id' => (int)$location->id,
                    'name' => $location->name,
                    'city_id' => isset($location->city_id) ? (int)$location->city_id : null,
                    'city_name' => isset($location->city_name) ? $location->city_name : null,
                    'status' => $location->status,
                    'created_at' => isset($location->created_at) ? $location->created_at : null,
                    'image' => isset($location->image) && !empty($location->image) ? base_url($location->image) : null
                );
                
                if ($with_count && isset($location->property_count)) {
                    $loc_data['property_count'] = (int)$location->property_count;
                }
                
                $formatted_locations[] = $loc_data;
            }
            
            $this->_send_response(true, array(
                'locations' => $formatted_locations,
                'total' => count($formatted_locations)
            ), 'Locations retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving locations', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get location by ID
     * GET /api/mobile/locations/{id}
     */
    public function location($id = null)
    {
        try {
            if (!$id) {
                $id = $this->uri->segment(4);
            }
            
            if (!$id) {
                $this->_send_response(false, null, 'Location ID is required', array('id' => 'Location ID is required'));
                return;
            }
            
            $location = $this->Location_model->get_by_id($id);
            
            if (!$location) {
                $this->_send_response(false, null, 'Location not found', array('id' => 'Location not found'));
                return;
            }
            
            $loc_data = array(
                'id' => (int)$location->id,
                'name' => $location->name,
                'city_id' => isset($location->city_id) ? (int)$location->city_id : null,
                'city_name' => isset($location->city_name) ? $location->city_name : null,
                'status' => $location->status,
                'created_at' => isset($location->created_at) ? $location->created_at : null,
                'image' => isset($location->image) && !empty($location->image) ? base_url($location->image) : null
            );
            
            $this->_send_response(true, $loc_data, 'Location retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving location', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get locations by city
     * GET /api/mobile/locations/city/{city_id}
     */
    public function locations_by_city($city_id = null)
    {
        try {
            if (!$city_id) {
                $city_id = $this->uri->segment(5);
            }
            
            if (!$city_id) {
                $this->_send_response(false, null, 'City ID is required', array('city_id' => 'City ID is required'));
                return;
            }
            
            $locations = $this->Location_model->get_by_city($city_id, 'active');
            
            $formatted_locations = array();
            foreach ($locations as $location) {
                $loc_data = array(
                    'id' => (int)$location->id,
                    'name' => $location->name,
                    'city_id' => (int)$location->city_id,
                    'status' => $location->status,
                    'image' => isset($location->image) && !empty($location->image) ? base_url($location->image) : null
                );
                
                $formatted_locations[] = $loc_data;
            }
            
            $this->_send_response(true, array(
                'locations' => $formatted_locations,
                'total' => count($formatted_locations)
            ), 'Locations retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving locations', array('message' => $e->getMessage()));
        }
    }

    // ==================== BANNERS API ====================

    /**
     * Get active banners
     * GET /api/mobile/banners
     */
    public function banners()
    {
        try {
            $banners = $this->Banner_model->get_active();
            
            $formatted_banners = array();
            foreach ($banners as $banner) {
                $banner_data = array(
                    'id' => (int)$banner->id,
                    'title' => isset($banner->title) ? $banner->title : '',
                    'description' => isset($banner->description) ? $banner->description : '',
                    'image' => !empty($banner->image) ? base_url($banner->image) : null,
                    'link' => isset($banner->link) ? $banner->link : null,
                    'status' => $banner->status,
                    'created_at' => isset($banner->created_at) ? $banner->created_at : null
                );
                
                $formatted_banners[] = $banner_data;
            }
            
            $this->_send_response(true, array(
                'banners' => $formatted_banners,
                'total' => count($formatted_banners)
            ), 'Banners retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving banners', array('message' => $e->getMessage()));
        }
    }

    // ==================== OFFER BANNERS API ====================

    /**
     * Get active offer banner
     * GET /api/mobile/offer_banner
     */
    public function offer_banner()
    {
        try {
            $offer_banner = $this->Offer_banner_model->get_active();
            
            if ($offer_banner) {
                $banner_data = array(
                    'id' => (int)$offer_banner->id,
                    'title' => isset($offer_banner->title) ? $offer_banner->title : null,
                    'image' => !empty($offer_banner->image) ? base_url($offer_banner->image) : null,
                    'link' => isset($offer_banner->link) && !empty($offer_banner->link) ? $offer_banner->link : null,
                    'status' => $offer_banner->status,
                    'created_at' => isset($offer_banner->created_at) ? $offer_banner->created_at : null
                );
                
                $this->_send_response(true, $banner_data, 'Offer banner retrieved successfully');
            } else {
                $this->_send_response(true, null, 'No active offer banner found');
            }
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving offer banner', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get all offer banners
     * GET /api/mobile/offer_banners?status=active
     */
    public function offer_banners()
    {
        try {
            $status = $this->input->get('status') ?: null;
            
            $offer_banners = $this->Offer_banner_model->get_all($status);
            
            $formatted_banners = array();
            foreach ($offer_banners as $banner) {
                $banner_data = array(
                    'id' => (int)$banner->id,
                    'title' => isset($banner->title) ? $banner->title : null,
                    'image' => !empty($banner->image) ? base_url($banner->image) : null,
                    'link' => isset($banner->link) && !empty($banner->link) ? $banner->link : null,
                    'status' => $banner->status,
                    'created_at' => isset($banner->created_at) ? $banner->created_at : null
                );
                
                $formatted_banners[] = $banner_data;
            }
            
            $this->_send_response(true, array(
                'offer_banners' => $formatted_banners,
                'total' => count($formatted_banners)
            ), 'Offer banners retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving offer banners', array('message' => $e->getMessage()));
        }
    }

    // ==================== CONTACT API ====================

    /**
     * Submit contact form
     * POST /api/mobile/contact
     * Body: name, email, phone, subject, message
     */
    public function contact()
    {
        try {
            // Get input data (handles both JSON and form data)
            $input_data = $this->_get_input();
            
            // Set validation rules
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'required');

            // Set data for validation
            if (!empty($input_data)) {
                $_POST = $input_data;
            }

            if ($this->form_validation->run() == FALSE) {
                $this->_send_response(false, null, 'Validation failed', $this->form_validation->error_array());
                return;
            }

            $data = array(
                'name' => $this->_get_input('name'),
                'email' => $this->_get_input('email'),
                'phone' => $this->_get_input('phone') ?: null,
                'subject' => $this->_get_input('subject') ?: null,
                'message' => $this->_get_input('message'),
                'status' => 'new'
            );

            $id = $this->Contact_model->create($data);
            
            if ($id) {
                $this->_send_response(true, array('id' => $id), 'Contact form submitted successfully');
            } else {
                $this->_send_response(false, null, 'Failed to save contact form', array('message' => 'Database error'));
            }
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error submitting contact form', array('message' => $e->getMessage()));
        }
    }

    // ==================== ENQUIRY API ====================

    /**
     * Submit property enquiry
     * POST /api/mobile/enquiry
     * Body: property_id, name, email, phone, message
     */
    public function enquiry()
    {
        try {
            // Get input data (handles both JSON and form data)
            $input_data = $this->_get_input();
            
            // Set validation rules
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'required');

            // Set data for validation
            if (!empty($input_data)) {
                $_POST = $input_data;
            }

            if ($this->form_validation->run() == FALSE) {
                $this->_send_response(false, null, 'Validation failed', $this->form_validation->error_array());
                return;
            }

            $property_id = $this->_get_input('property_id');
            $data = array(
                'property_id' => $property_id ? (int)$property_id : null,
                'name' => $this->_get_input('name'),
                'email' => $this->_get_input('email'),
                'phone' => $this->_get_input('phone') ?: null,
                'message' => $this->_get_input('message'),
                'status' => 'new'
            );

            $id = $this->Enquiry_model->create($data);
            
            if ($id) {
                $this->_send_response(true, array('id' => $id), 'Enquiry submitted successfully');
            } else {
                $this->_send_response(false, null, 'Failed to save enquiry', array('message' => 'Database error'));
            }
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error submitting enquiry', array('message' => $e->getMessage()));
        }
    }

    /**
     * Get enquiries by customer ID
     * GET /api/mobile/enquiries/customer/{customer_id}?status=new
     * Query params: status (optional) - filter by status (new, read, replied)
     */
    public function enquiries_by_customer($customer_id = null)
    {
        try {
            if (!$customer_id) {
                $customer_id = $this->uri->segment(4);
            }
            
            if (!$customer_id) {
                $this->_send_response(false, null, 'Customer ID is required', array('customer_id' => 'Customer ID is required'));
                return;
            }
            
            $status = $this->input->get('status') ?: null;
            
            $enquiries = $this->Enquiry_model->get_by_customer_id($customer_id, $status);
            
            $formatted_enquiries = array();
            foreach ($enquiries as $enquiry) {
                $enquiry_data = array(
                    'id' => (int)$enquiry->id,
                    'property_id' => $enquiry->property_id ? (int)$enquiry->property_id : null,
                    'property_name' => isset($enquiry->property_name) ? $enquiry->property_name : null,
                    'property_image' => isset($enquiry->property_image) && !empty($enquiry->property_image) ? base_url($enquiry->property_image) : null,
                    'name' => $enquiry->name,
                    'email' => $enquiry->email,
                    'phone' => $enquiry->phone,
                    'message' => $enquiry->message,
                    'status' => $enquiry->status,
                    'created_at' => $enquiry->created_at
                );
                
                $formatted_enquiries[] = $enquiry_data;
            }
            
            $this->_send_response(true, array(
                'enquiries' => $formatted_enquiries,
                'total' => count($formatted_enquiries),
                'customer_id' => (int)$customer_id
            ), 'Enquiries retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving enquiries', array('message' => $e->getMessage()));
        }
    }

    // ==================== HOME/DASHBOARD API ====================

    /**
     * Get home page data (all essential data in one call)
     * GET /api/mobile/home
     */
    public function home()
    {
        try {
            $data = array();
            
            // Get featured properties
            $featured = $this->Property_model->get_featured_properties(6);
            $data['featured_properties'] = array();
            foreach ($featured as $property) {
                $data['featured_properties'][] = $this->_format_property($property);
            }
            
            // Get latest properties
            $latest = $this->Property_model->get_latest_for_sale(6);
            $data['latest_properties'] = array();
            foreach ($latest as $property) {
                $data['latest_properties'][] = $this->_format_property($property);
            }
            
            // Get categories with property count
            $categories = $this->Category_model->get_all_with_property_count('active');
            $data['categories'] = array();
            foreach ($categories as $category) {
                $cat_data = array(
                    'id' => (int)$category->id,
                    'category_name' => $category->category_name,
                    'property_count' => isset($category->property_count) ? (int)$category->property_count : 0,
                    'image' => isset($category->image) && !empty($category->image) ? base_url($category->image) : null
                );
                $data['categories'][] = $cat_data;
            }
            
            // Get cities
            $cities = $this->City_model->get_all('active');
            $data['cities'] = array();
            foreach ($cities as $city) {
                $data['cities'][] = array(
                    'id' => (int)$city->id,
                    'name' => $city->name,
                    'image' => isset($city->image) && !empty($city->image) ? base_url($city->image) : null
                );
            }
            
            // Get locations with property count
            $locations = $this->Location_model->get_all_with_property_count('active');
            $data['locations'] = array();
            foreach ($locations as $location) {
                $loc_data = array(
                    'id' => (int)$location->id,
                    'name' => $location->name,
                    'property_count' => isset($location->property_count) ? (int)$location->property_count : 0,
                    'image' => isset($location->image) && !empty($location->image) ? base_url($location->image) : null
                );
                $data['locations'][] = $loc_data;
            }
            
            // Get active banners
            $banners = $this->Banner_model->get_active();
            $data['banners'] = array();
            foreach ($banners as $banner) {
                $data['banners'][] = array(
                    'id' => (int)$banner->id,
                    'title' => isset($banner->title) ? $banner->title : '',
                    'image' => !empty($banner->image) ? base_url($banner->image) : null,
                    'link' => isset($banner->link) ? $banner->link : null
                );
            }
            
            // Get latest blogs
            $blogs = $this->Blog_model->get_all('active');
            $data['latest_blogs'] = array();
            $blog_count = 0;
            foreach ($blogs as $blog) {
                if ($blog_count >= 3) break;
                $data['latest_blogs'][] = $this->_format_blog($blog);
                $blog_count++;
            }
            
            $this->_send_response(true, $data, 'Home data retrieved successfully');
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error retrieving home data', array('message' => $e->getMessage()));
        }
    }

    // ==================== AUTHENTICATION API ====================

    /**
     * Send OTP to phone number
     * POST /api/mobile/send_otp
     */
    public function send_otp()
    {
        try {
            $input = $this->_get_input();
            $phone = isset($input['phone']) ? $input['phone'] : $this->input->post('phone');
            $country_code = isset($input['country_code']) ? $input['country_code'] : ($this->input->post('country_code') ?: '+91');
            
            if (empty($phone)) {
                $this->_send_response(false, null, 'Phone number is required');
                return;
            }
            
            // Generate 6-digit OTP
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // OTP expires in 1 minute (60 seconds)
            $otp_expires_at = date('Y-m-d H:i:s', time() + 60);
            
            // Check if user exists
            $user = $this->User_model->get_by_phone($phone, $country_code);
            
            if ($user) {
                // Update existing user's OTP
                $this->User_model->update_otp($phone, $country_code, $otp, $otp_expires_at);
            } else {
                // Create new user with OTP
                $this->User_model->create(array(
                    'phone' => $phone,
                    'country_code' => $country_code,
                    'otp' => $otp,
                    'otp_expires_at' => $otp_expires_at,
                    'is_verified' => 0,
                    'status' => 'active'
                ));
            }
            
            // Send OTP via WhatsApp
            $full_phone = $country_code . $phone;
            
            // Load WhatsApp config
            $this->config->load('whatsapp', TRUE);
            $whatsapp_config = $this->config->item('whatsapp');
            
            // Check if development mode is enabled
            $development_mode = isset($whatsapp_config['development_mode']) && $whatsapp_config['development_mode'] === true;
            $development_mode = true; // Force development mode for now
            
            if ($development_mode) {
                // Development mode: Skip actual WhatsApp sending
                $curl_command = $this->whatsapp_library->get_curl_command($full_phone, $otp);
                
                $this->_send_response(true, array(
                    'is_new_user' => !$user,
                    'development_mode' => true,
                    'otp' => $otp,
                    'curl_command' => $curl_command
                ), 'OTP generated (Development Mode - Not sent via WhatsApp)');
            } else {
                // Production mode: Actually send OTP via WhatsApp
                $whatsapp_result = $this->whatsapp_library->send_otp($full_phone, $otp);
                
                if ($whatsapp_result['success']) {
                    $this->_send_response(true, array('is_new_user' => !$user), 'OTP sent successfully to your WhatsApp number');
                } else {
                    $error_message = isset($whatsapp_result['message']) ? $whatsapp_result['message'] : 'Unknown error';
                    $this->_send_response(false, null, 'Failed to send OTP via WhatsApp: ' . $error_message, array('error' => $error_message));
                }
            }
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error sending OTP: ' . $e->getMessage());
        }
    }

    /**
     * Verify OTP and login
     * POST /api/mobile/verify_otp
     */
    public function verify_otp()
    {
        try {
            $input = $this->_get_input();
            $phone = isset($input['phone']) ? $input['phone'] : $this->input->post('phone');
            $country_code = isset($input['country_code']) ? $input['country_code'] : ($this->input->post('country_code') ?: '+91');
            $otp = isset($input['otp']) ? $input['otp'] : $this->input->post('otp');
            
            if (empty($phone) || empty($otp)) {
                $this->_send_response(false, null, 'Phone number and OTP are required');
                return;
            }
            
            $result = $this->User_model->verify_otp($phone, $country_code, $otp);
            
            if (is_array($result) && isset($result['success']) && $result['success']) {
                $user = $result['user'];
                
                // Set session
                $this->session->set_userdata(array(
                    'user_logged_in' => true,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone,
                    'user_country_code' => $user->country_code,
                    'user_address' => $user->address
                ));
                
                // Check if user needs to complete profile
                $needs_profile = empty($user->name) || empty($user->email);
                
                $this->_send_response(true, array(
                    'needs_profile' => $needs_profile,
                    'user' => array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'country_code' => $user->country_code,
                        'address' => $user->address
                    )
                ), 'OTP verified successfully');
            } else {
                $error_message = 'Invalid or expired OTP';
                if (is_array($result) && isset($result['message'])) {
                    $error_message = $result['message'];
                }
                
                $this->_send_response(false, null, $error_message, array('error_type' => isset($result['error']) ? $result['error'] : 'unknown'));
            }
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error verifying OTP: ' . $e->getMessage());
        }
    }

    /**
     * Save/Update user profile
     * POST /api/mobile/save_profile
     */
    public function save_profile()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $input = $this->_get_input();
            $user_id = $this->session->userdata('user_id');
            $name = isset($input['name']) ? $input['name'] : $this->input->post('name');
            $email = isset($input['email']) ? $input['email'] : $this->input->post('email');
            $address = isset($input['address']) ? $input['address'] : $this->input->post('address');
            
            if (empty($name)) {
                $this->_send_response(false, null, 'Name is required');
                return;
            }
            
            $data = array('name' => $name, 'address' => $address);
            if (!empty($email)) {
                $data['email'] = $email;
            }
            
            $this->User_model->update($user_id, $data);
            
            // Update session
            $this->session->set_userdata(array(
                'user_name' => $name,
                'user_email' => $email,
                'user_address' => $address
            ));
            
            $this->_send_response(true, null, 'Profile saved successfully');
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error saving profile: ' . $e->getMessage());
        }
    }

    /**
     * Get user profile
     * GET /api/mobile/profile
     */
    public function profile()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $user_id = $this->session->userdata('user_id');
            $user = $this->User_model->get_by_id($user_id);
            
            if ($user) {
                $this->_send_response(true, array(
                    'user' => array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'country_code' => $user->country_code,
                        'address' => $user->address,
                        'is_verified' => (bool)$user->is_verified,
                        'status' => $user->status,
                        'created_at' => $user->created_at
                    )
                ), 'Profile retrieved successfully');
            } else {
                $this->_send_response(false, null, 'User not found');
            }
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error fetching profile: ' . $e->getMessage());
        }
    }

    /**
     * Check if user is logged in
     * GET /api/mobile/check
     */
    public function check()
    {
        if ($this->session->userdata('user_logged_in')) {
            $this->_send_response(true, array(
                'logged_in' => true,
                'user' => array(
                    'id' => $this->session->userdata('user_id'),
                    'name' => $this->session->userdata('user_name'),
                    'email' => $this->session->userdata('user_email'),
                    'phone' => $this->session->userdata('user_phone'),
                    'country_code' => $this->session->userdata('user_country_code'),
                    'address' => $this->session->userdata('user_address')
                )
            ), 'User is logged in');
        } else {
            $this->_send_response(true, array('logged_in' => false), 'User is not logged in');
        }
    }

    /**
     * Logout
     * POST /api/mobile/logout
     */
    public function logout()
    {
        $this->session->unset_userdata('user_logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_phone');
        $this->session->unset_userdata('user_country_code');
        $this->session->unset_userdata('user_address');
        
        $this->_send_response(true, null, 'Logged out successfully');
    }

    /**
     * Check if phone number exists
     * POST /api/mobile/check_phone_exists
     */
    public function check_phone_exists()
    {
        try {
            $input = $this->_get_input();
            $phone = isset($input['phone']) ? $input['phone'] : $this->input->post('phone');
            $country_code = isset($input['country_code']) ? $input['country_code'] : ($this->input->post('country_code') ?: '+91');
            
            if (empty($phone)) {
                $this->_send_response(false, null, 'Phone number is required');
                return;
            }
            
            $exists = $this->User_model->is_phone_exists($phone, $country_code);
            
            $this->_send_response(true, array(
                'exists' => $exists,
                'message' => $exists ? 'Phone number already registered' : 'Phone number available'
            ), 'Phone check completed');
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error checking phone: ' . $e->getMessage());
        }
    }

    /**
     * Update user profile (alias for save_profile)
     * POST /api/mobile/update_profile
     */
    public function update_profile()
    {
        $this->save_profile();
    }

    /**
     * Resend OTP (alias for send_otp)
     * POST /api/mobile/resend_otp
     */
    public function resend_otp()
    {
        $this->send_otp();
    }

    /**
     * Change phone number
     * POST /api/mobile/change_phone
     */
    public function change_phone()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $input = $this->_get_input();
            $user_id = $this->session->userdata('user_id');
            $new_phone = isset($input['phone']) ? $input['phone'] : $this->input->post('phone');
            $country_code = isset($input['country_code']) ? $input['country_code'] : ($this->input->post('country_code') ?: '+91');
            
            if (empty($new_phone)) {
                $this->_send_response(false, null, 'Phone number is required');
                return;
            }
            
            // Check if new phone already exists
            $existing_user = $this->User_model->get_by_phone($new_phone, $country_code);
            if ($existing_user && $existing_user->id != $user_id) {
                $this->_send_response(false, null, 'Phone number already registered to another account');
                return;
            }
            
            // Generate OTP for new phone
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $otp_expires_at = date('Y-m-d H:i:s', time() + 60);
            
            // Update user with new phone and OTP
            $this->User_model->update($user_id, array(
                'phone' => $new_phone,
                'country_code' => $country_code,
                'otp' => $otp,
                'otp_expires_at' => $otp_expires_at,
                'is_verified' => 0
            ));
            
            // Send OTP via WhatsApp
            $full_phone = $country_code . $new_phone;
            $this->config->load('whatsapp', TRUE);
            $whatsapp_config = $this->config->item('whatsapp');
            $development_mode = isset($whatsapp_config['development_mode']) && $whatsapp_config['development_mode'] === true;
            $development_mode = true; // Force development mode
            
            if ($development_mode) {
                $this->_send_response(true, array(
                    'otp' => $otp,
                    'requires_verification' => true
                ), 'OTP generated for phone change (Development Mode)');
            } else {
                $whatsapp_result = $this->whatsapp_library->send_otp($full_phone, $otp);
                if ($whatsapp_result['success']) {
                    $this->_send_response(true, array('requires_verification' => true), 'OTP sent to new phone number');
                } else {
                    $error_message = isset($whatsapp_result['message']) ? $whatsapp_result['message'] : 'Unknown error';
                    $this->_send_response(false, null, 'Failed to send OTP: ' . $error_message);
                }
            }
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error changing phone: ' . $e->getMessage());
        }
    }

    /**
     * Verify phone change OTP
     * POST /api/mobile/verify_phone_change
     */
    public function verify_phone_change()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $input = $this->_get_input();
            $user_id = $this->session->userdata('user_id');
            $otp = isset($input['otp']) ? $input['otp'] : $this->input->post('otp');
            
            if (empty($otp)) {
                $this->_send_response(false, null, 'OTP is required');
                return;
            }
            
            $user = $this->User_model->get_by_id($user_id);
            if (!$user) {
                $this->_send_response(false, null, 'User not found');
                return;
            }
            
            // Verify OTP
            if (empty($user->otp) || $user->otp != $otp) {
                $this->_send_response(false, null, 'Invalid OTP');
                return;
            }
            
            // Check if OTP expired
            if (strtotime($user->otp_expires_at) < time()) {
                $this->_send_response(false, null, 'OTP has expired');
                return;
            }
            
            // Update user as verified and clear OTP
            $this->User_model->update($user_id, array(
                'is_verified' => 1,
                'otp' => null,
                'otp_expires_at' => null
            ));
            
            // Update session
            $this->session->set_userdata(array(
                'user_phone' => $user->phone,
                'user_country_code' => $user->country_code
            ));
            
            $this->_send_response(true, null, 'Phone number changed successfully');
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error verifying phone change: ' . $e->getMessage());
        }
    }

    /**
     * Delete user account
     * POST /api/mobile/delete_account
     */
    public function delete_account()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $user_id = $this->session->userdata('user_id');
            
            // Soft delete - update status to deleted
            $this->User_model->update($user_id, array('status' => 'deleted'));
            
            // Clear session
            $this->session->sess_destroy();
            
            $this->_send_response(true, null, 'Account deleted successfully');
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error deleting account: ' . $e->getMessage());
        }
    }

    /**
     * Refresh session
     * POST /api/mobile/refresh_session
     */
    public function refresh_session()
    {
        try {
            if (!$this->session->userdata('user_logged_in')) {
                $this->_send_response(false, null, 'Please login first');
                return;
            }
            
            $user_id = $this->session->userdata('user_id');
            $user = $this->User_model->get_by_id($user_id);
            
            if (!$user || $user->status != 'active') {
                $this->session->sess_destroy();
                $this->_send_response(false, null, 'User account is inactive or deleted');
                return;
            }
            
            // Refresh session data
            $this->session->set_userdata(array(
                'user_logged_in' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'user_country_code' => $user->country_code,
                'user_address' => $user->address
            ));
            
            $this->_send_response(true, array(
                'user' => array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country_code' => $user->country_code,
                    'address' => $user->address
                )
            ), 'Session refreshed successfully');
            
        } catch (Exception $e) {
            $this->_send_response(false, null, 'Error refreshing session: ' . $e->getMessage());
        }
    }
}

