<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_phone($phone, $country_code = '+91')
    {
        return $this->db->get_where('users', array(
            'phone' => $phone,
            'country_code' => $country_code
        ))->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function create($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function update_otp($phone, $country_code, $otp, $expires_at)
    {
        $this->db->where('phone', $phone);
        $this->db->where('country_code', $country_code);
        return $this->db->update('users', array(
            'otp' => $otp,
            'otp_expires_at' => $expires_at
        ));
    }

    public function verify_otp($phone, $country_code, $otp)
    {
        $user = $this->get_by_phone($phone, $country_code);
        
        if (!$user) {
            return array('success' => false, 'error' => 'user_not_found', 'message' => 'User not found');
        }
        
        // Check if OTP exists
        if (empty($user->otp)) {
            return array('success' => false, 'error' => 'no_otp', 'message' => 'No OTP found. Please request a new OTP.');
        }
        
        // Check if OTP is expired
        if (empty($user->otp_expires_at) || strtotime($user->otp_expires_at) <= time()) {
            return array('success' => false, 'error' => 'otp_expired', 'message' => 'OTP has expired. Please request a new OTP.');
        }
        
        // Check if OTP matches
        if ($user->otp != $otp) {
            return array('success' => false, 'error' => 'invalid_otp', 'message' => 'Invalid OTP. Please check and try again.');
        }
        
        // OTP is valid - Mark as verified and clear OTP
        $this->db->where('id', $user->id);
        $this->db->update('users', array(
            'is_verified' => 1,
            'otp' => null,
            'otp_expires_at' => null
        ));
        
        return array('success' => true, 'user' => $user);
    }
    
    /**
     * Check OTP expiration status
     * @param string $phone
     * @param string $country_code
     * @return array Status information
     */
    public function check_otp_status($phone, $country_code = '+91')
    {
        $user = $this->get_by_phone($phone, $country_code);
        
        if (!$user || empty($user->otp)) {
            return array(
                'has_otp' => false,
                'expired' => false,
                'expires_at' => null,
                'time_remaining' => 0
            );
        }
        
        $expires_at = strtotime($user->otp_expires_at);
        $current_time = time();
        $time_remaining = max(0, $expires_at - $current_time);
        $is_expired = $expires_at <= $current_time;
        
        return array(
            'has_otp' => true,
            'expired' => $is_expired,
            'expires_at' => $user->otp_expires_at,
            'time_remaining' => $time_remaining,
            'expires_at_timestamp' => $expires_at
        );
    }

    public function is_phone_exists($phone, $country_code = '+91')
    {
        $this->db->where('phone', $phone);
        $this->db->where('country_code', $country_code);
        return $this->db->count_all_results('users') > 0;
    }
}

