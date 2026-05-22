<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_model extends CI_Model {

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
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('properties')->result();
    }

    public function get_by_process($process, $status = 'active')
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        if ($process && strtolower($process) !== 'all') {
            $this->db->where('process', ucfirst(strtolower($process)));
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('properties')->result();
    }

    public function get_related($property_id, $city, $limit = 4)
    {
        $this->db->where('status', 'active');
        $this->db->where('id !=', $property_id);
        $this->db->where('city', $city);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('properties')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('properties', array('id' => $id))->row();
    }

    public function get_by_slug($slug)
    {
        return $this->db->get_where('properties', array('slug' => $slug, 'status' => 'active'))->row();
    }

    public function create($data)
    {
        $this->db->insert('properties', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('properties', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('properties');
    }

    public function count_all($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results('properties');
    }

    public function search($filters = array())
    {
        if (isset($filters['process']) && !empty($filters['process']) && strtolower($filters['process']) !== 'all') {
            $this->db->where('process', ucfirst(strtolower($filters['process'])));
        }
        if (isset($filters['category']) && !empty($filters['category'])) {
            // Handle both ID (numeric) and name (string) searches
            // Properties table stores category as name (category_name), so try direct match first
            if (is_numeric($filters['category'])) {
                // It's an ID, try to find the category name
                try {
                    $this->load->model('Category_model');
                    $category = $this->Category_model->get_by_id($filters['category']);
                    if ($category && isset($category->category_name)) {
                        $this->db->where('category', $category->category_name);
                    } else {
                        // Fallback: try direct ID match (in case properties table stores ID)
                        $this->db->where('category', $filters['category']);
                    }
                } catch (Exception $e) {
                    // Fallback: try direct match
                    $this->db->where('category', $filters['category']);
                }
            } else {
                // It's a name, try direct match (properties table likely stores category as name)
                $this->db->where('category', $filters['category']);
            }
        }
        if (isset($filters['city']) && !empty($filters['city'])) {
            // Handle both ID (numeric) and name (string) searches
            if (is_numeric($filters['city'])) {
                // It's an ID, try to find the city name
                try {
                    $this->load->model('City_model');
                    $city = $this->City_model->get_by_id($filters['city']);
                    if ($city && isset($city->name)) {
                        $this->db->where('city', $city->name);
                    } else {
                        // Fallback: try direct ID match
                        $this->db->where('city', $filters['city']);
                    }
                } catch (Exception $e) {
                    // Fallback: try direct match
                    $this->db->where('city', $filters['city']);
                }
            } else {
                // It's a name, try direct match
                $this->db->where('city', $filters['city']);
            }
        }
        if (isset($filters['location']) && !empty($filters['location'])) {
            // Handle both ID (numeric) and name (string) searches
            if (is_numeric($filters['location'])) {
                // It's an ID, try to find the location name
                try {
                    $this->load->model('Location_model');
                    $location = $this->Location_model->get_by_id($filters['location']);
                    if ($location && isset($location->name)) {
                        $this->db->where('location', $location->name);
                    } else {
                        // Fallback: try direct ID match
                        $this->db->where('location', $filters['location']);
                    }
                } catch (Exception $e) {
                    // Fallback: try direct match
                    $this->db->where('location', $filters['location']);
                }
            } else {
                // It's a name, try direct match
                $this->db->where('location', $filters['location']);
            }
        }
        // Handle price_range filter (Lakh/Crore)
        if (isset($filters['price_range']) && !empty($filters['price_range'])) {
            $price_range = strtolower(trim($filters['price_range']));
            if ($price_range === 'lakh') {
                // Filter for properties in Lakh range (1 lakh to 99.99 lakhs = 100,000 to 9,999,999)
                $this->db->where('price >=', 100000);
                $this->db->where('price <', 10000000);
            } elseif ($price_range === 'crore') {
                // Filter for properties in Crore range (1 crore and above = 10,000,000 and above)
                $this->db->where('price >=', 10000000);
            }
        }
        // Handle min_price and max_price for backward compatibility
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            $this->db->where('price >=', $filters['min_price']);
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            $this->db->where('price <=', $filters['max_price']);
        }
        if (isset($filters['is_featured']) && $filters['is_featured'] == 1) {
            $this->db->where('is_featured', 1);
        }
        if (isset($filters['is_latest']) && $filters['is_latest'] == 1) {
            $this->db->where('is_latest', 1);
        }
        if (isset($filters['type']) && !empty($filters['type'])) {
            // Try to match common type variations
            $type = strtolower(trim($filters['type']));
            if ($type === 'for_rent' || $type === 'for rent') {
                $this->db->group_start();
                $this->db->where('type', 'for_rent');
                $this->db->or_where('type', 'For Rent');
                $this->db->group_end();
            } elseif ($type === 'for_sale' || $type === 'for sale') {
                $this->db->group_start();
                $this->db->where('type', 'for_sale');
                $this->db->or_where('type', 'For Sale');
                $this->db->group_end();
            } else {
                // Fallback to exact match
                $this->db->where('type', $filters['type']);
            }
        }
        
        // Filter by amenities/features (JSON array search)
        if (isset($filters['amenities']) && !empty($filters['amenities'])) {
            if (is_array($filters['amenities'])) {
                // Multiple amenities - property must have at least one
                $amenities = $filters['amenities'];
                $this->db->group_start();
                foreach ($amenities as $index => $amenity) {
                    if ($index == 0) {
                        $this->db->like('features', '"' . $this->db->escape_like_str($amenity) . '"');
                    } else {
                        $this->db->or_like('features', '"' . $this->db->escape_like_str($amenity) . '"');
                    }
                }
                $this->db->group_end();
            } else {
                // Single amenity
                $this->db->like('features', '"' . $this->db->escape_like_str($filters['amenities']) . '"');
            }
        }
        
        // Only show active properties
        $this->db->where('status', 'active');
        
        // Sorting
        if (isset($filters['sort_by'])) {
            switch($filters['sort_by']) {
                case 'newest':
                    $this->db->order_by('created_at', 'DESC');
                    break;
                case 'oldest':
                    $this->db->order_by('created_at', 'ASC');
                    break;
                case 'featured':
                    $this->db->order_by('is_featured', 'DESC');
                    $this->db->order_by('created_at', 'DESC');
                    break;
                case 'price_low':
                    $this->db->order_by('price', 'ASC');
                    break;
                case 'price_high':
                    $this->db->order_by('price', 'DESC');
                    break;
                case 'latest':
                    $this->db->order_by('is_latest', 'DESC');
                    $this->db->order_by('created_at', 'DESC');
                    break;
                default:
                    $this->db->order_by('created_at', 'DESC');
            }
        } else {
            $this->db->order_by('created_at', 'DESC');
        }
        
        return $this->db->get('properties')->result();
    }

    public function get_categories()
    {
        $this->db->select('category');
        $this->db->distinct();
        $this->db->where('status', 'active');
        $this->db->order_by('category', 'ASC');
        return $this->db->get('properties')->result();
    }

    public function get_latest_for_sale($limit = 3)
    {
        $this->db->where('status', 'active');   
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('properties')->result();
    } 
    public function get_featured_properties($limit = 3)
    {
        $this->db->where('status', 'active');
        $this->db->where('is_featured', 1);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('properties')->result();
    }

    public function get_featured_and_latest_properties($limit = 10)
    {
        $this->db->where('status', 'active');
        $this->db->group_start();
        $this->db->or_where('is_latest', 1);
        $this->db->group_end();
        $this->db->order_by('is_latest', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('properties')->result();
    }

    public function get_cities_with_property_count($limit = 6)
    {
        $this->db->select('city, COUNT(*) as property_count, MIN(main_image) as sample_image');
        $this->db->from('properties');
        $this->db->where('status', 'active');
        $this->db->group_by('city');
        $this->db->order_by('property_count', 'DESC');
        $this->db->order_by('city', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_all_amenities()
    {
        // Older databases may not have this column yet; fail gracefully.
        if (!$this->db->field_exists('features', 'properties')) {
            return array();
        }

        $this->db->select('features');
        $this->db->from('properties');
        $this->db->where('status', 'active');
        $this->db->where('features IS NOT NULL');
        $this->db->where('features !=', '');
        $this->db->where('features !=', '[]');
        $results = $this->db->get()->result();
        
        $amenities = array();
        foreach ($results as $row) {
            if (!empty($row->features)) {
                $features_array = json_decode($row->features, true);
                if (is_array($features_array)) {
                    foreach ($features_array as $feature) {
                        if (!empty($feature) && !in_array($feature, $amenities)) {
                            $amenities[] = $feature;
                        }
                    }
                }
            }
        }
        
        sort($amenities);
        return $amenities;
    }
}

