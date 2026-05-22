<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Resolve property main image URL.
 * Checks disk, falls back to images/project-image-N.jpg
 */
function get_property_image($property)
{
    $img_n   = (($property->id - 18) % 8) + 1;
    if ($img_n < 1) $img_n = 1;
    $default = base_url('images/project-image-' . $img_n . '.jpg');

    $source = !empty($property->main_image) ? trim($property->main_image) : null;

    if ($source) {
        if (strpos($source, 'http://') === 0 || strpos($source, 'https://') === 0) {
            return $source;
        }
        $disk = FCPATH . ltrim(str_replace('\\', '/', $source), '/');
        if (file_exists($disk)) {
            return base_url($source);
        }
    }

    return $default;
}

/**
 * Resolve all gallery image URLs for a property, verified on disk.
 */
function get_property_gallery($property)
{
    $img_n   = (($property->id - 18) % 8) + 1;
    if ($img_n < 1) $img_n = 1;
    $main_img = get_property_image($property);
    $result   = [$main_img];

    if (!empty($property->gallery)) {
        $imgs = json_decode($property->gallery, true);
        if (is_array($imgs)) {
            foreach ($imgs as $path) {
                $path = trim($path);
                if (empty($path)) continue;
                if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
                    $result[] = $path;
                    continue;
                }
                $disk = FCPATH . ltrim(str_replace('\\', '/', $path), '/');
                if (file_exists($disk)) {
                    $result[] = base_url($path);
                }
            }
        }
    }

    return array_unique($result);
}

/**
 * Return canonical URL for a property.
 */
function get_property_url($property)
{
    if (!empty($property->slug)) {
        return site_url('property/' . $property->slug);
    }
    return site_url('property/' . $property->id);
}

/**
 * Format price in Indian currency (Lakh / Crore)
 */
if (!function_exists('format_price_indian')) {
    function format_price_indian($price)
    {
        $price = floatval($price);
        if ($price >= 10000000) {
            return '₹' . number_format($price / 10000000, 2) . ' Cr';
        } elseif ($price >= 100000) {
            return '₹' . number_format($price / 100000, 2) . ' L';
        }
        return '₹' . number_format($price, 0);
    }
}

/**
 * Get badge class for project process status.
 */
function get_process_badge($process)
{
    $map = [
        'Ongoing'   => 'badge-ongoing',
        'Upcoming'  => 'badge-upcoming',
        'Completed' => 'badge-completed',
    ];
    return isset($map[$process]) ? $map[$process] : 'badge-upcoming';
}
