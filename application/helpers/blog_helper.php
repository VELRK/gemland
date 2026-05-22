<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Resolve a blog's featured image URL.
 * Reads gallery JSON, verifies the file exists on disk,
 * and falls back to images/post-N.jpg if missing or empty.
 */
function get_blog_image($blog, $index = 0)
{
    $img_n   = (($blog->id - 1) % 6) + 1;
    $default = base_url('images/post-' . $img_n . '.jpg');

    if (!empty($blog->gallery)) {
        $imgs = json_decode($blog->gallery, true);

        if (is_array($imgs) && isset($imgs[$index]) && $imgs[$index] !== '') {
            $path = $imgs[$index];

            // External URL — use directly
            if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
                return $path;
            }

            // Local file — confirm it exists on disk before using
            $disk_path = FCPATH . ltrim(str_replace('\\', '/', $path), '/');
            if (file_exists($disk_path)) {
                return base_url($path);
            }
        }
    }

    return $default;
}

/**
 * Return all gallery image URLs for a blog, filtering out missing files.
 * Falls back to images/post-N.jpg as the only entry if none found.
 */
function get_blog_gallery($blog)
{
    $img_n   = (($blog->id - 1) % 6) + 1;
    $default = [base_url('images/post-' . $img_n . '.jpg')];

    if (empty($blog->gallery)) {
        return $default;
    }

    $imgs = json_decode($blog->gallery, true);
    if (!is_array($imgs) || empty($imgs)) {
        return $default;
    }

    $resolved = [];
    foreach ($imgs as $path) {
        if (empty($path)) continue;

        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            $resolved[] = $path;
            continue;
        }

        $disk_path = FCPATH . ltrim(str_replace('\\', '/', $path), '/');
        if (file_exists($disk_path)) {
            $resolved[] = base_url($path);
        }
    }

    return !empty($resolved) ? $resolved : $default;
}

/**
 * Return the canonical URL for a blog post.
 */
function get_blog_url($blog)
{
    if (!empty($blog->slug)) {
        return site_url('blog/post/' . $blog->slug);
    }
    return site_url('blog/detail/' . $blog->id);
}
