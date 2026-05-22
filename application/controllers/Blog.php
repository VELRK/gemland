<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('blog');
        $this->load->helper('slug');
    }

    public function index() {
        $data['page_title'] = 'Blog';
        $data['page'] = 'blog';
        $data['blogs'] = $this->Blog_model->get_all('active');

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/blog', $data);
        $this->load->view('frontend/footer');
    }

    // Slug-based detail: /blog/post/my-post-slug
    public function post($slug = null) {
        if (!$slug) {
            redirect('blog');
        }

        $blog = $this->Blog_model->get_by_slug($slug);

        if (!$blog || $blog->status != 'active') {
            // Maybe it's an ID
            if (is_numeric($slug)) {
                $blog = $this->Blog_model->get_by_id($slug);
                if ($blog && $blog->status == 'active') {
                    $slug = $this->_ensure_slug($blog);
                    redirect('blog/post/' . $slug, 'location', 301);
                }
            }
            redirect('blog');
        }

        $this->_show_detail($blog);
    }

    // Legacy ID-based: /blog/detail/14 → 301 redirect to slug URL
    public function detail($id = null) {
        if (!$id) {
            redirect('blog');
        }

        $blog = $this->Blog_model->get_by_id($id);

        if (!$blog || $blog->status != 'active') {
            redirect('blog');
        }

        $slug = $this->_ensure_slug($blog);
        redirect('blog/post/' . $slug, 'location', 301);
    }

    // Generate & persist slug if missing/placeholder
    private function _ensure_slug($blog) {
        if (!empty($blog->slug) && strlen($blog->slug) > 5 && strpos($blog->slug, '-') !== false) {
            return $blog->slug;
        }
        // Generate from name
        $base  = generate_slug($blog->name);
        $slug  = $base;
        $i     = 1;
        while (true) {
            $existing = $this->Blog_model->get_by_slug($slug);
            if (!$existing || $existing->id == $blog->id) break;
            $slug = $base . '-' . $i++;
        }
        $this->Blog_model->update($blog->id, array('slug' => $slug));
        return $slug;
    }

    private function _show_detail($blog) {
        $all_blogs = $this->Blog_model->get_all('active');
        $recent_blogs = array();
        foreach ($all_blogs as $b) {
            if ($b->id != $blog->id) {
                $recent_blogs[] = $b;
                if (count($recent_blogs) >= 3) break;
            }
        }

        $data['page_title'] = htmlspecialchars($blog->name);
        $data['page']       = 'blog-detail';
        $data['blog']       = $blog;
        $data['recent_blogs'] = $recent_blogs;

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/blog-detail', $data);
        $this->load->view('frontend/footer');
    }
}
