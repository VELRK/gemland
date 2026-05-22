<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (empty($static_source_file)) {
    echo '<p>Template source file is missing.</p>';
    return;
}

$source_path = FCPATH . $static_source_file;
if (!is_file($source_path)) {
    echo '<p>Template source file not found.</p>';
    return;
}

$html = file_get_contents($source_path);
if ($html === false) {
    echo '<p>Unable to load template source file.</p>';
    return;
}

if (preg_match('/<body[^>]*>([\s\S]*?)<\/body>/i', $html, $matches)) {
    $body = $matches[1];
} else {
    $body = $html;
}

// Keep CI header/footer as single source of truth.
$body = preg_replace('/<!--\s*Preloader Start\s*-->[\s\S]*?<!--\s*Preloader End\s*-->/i', '', $body);
$body = preg_replace('/<!--\s*Header Start\s*-->[\s\S]*?<!--\s*Header End\s*-->/i', '', $body);
$body = preg_replace('/<!--\s*Main Footer Start\s*-->[\s\S]*?<!--\s*Main Footer End\s*-->/i', '', $body);
$body = preg_replace('/<script\b[^>]*>[\s\S]*?<\/script>/i', '', $body);

if (!empty($static_prepend_inside_page_projects)) {
    if (preg_match('/<div class="page-projects">\s*<div class="container">/i', $body, $container_match)) {
        $replacement = $container_match[0] . $static_prepend_inside_page_projects;
        $body = preg_replace('/<div class="page-projects">\s*<div class="container">/i', $replacement, $body, 1);
    } else {
        $body = $static_prepend_inside_page_projects . $body;
    }
}

$route_map = array(
    'index.html' => '',
    'index-2.html' => '',
    'index-3.html' => '',
    'index-4.html' => '',
    'about.html' => 'about',
    'projects.html' => 'projects',
    'blog.html' => 'blog',
    'blog-single.html' => 'blog',
    'contact.html' => 'contact'
);

$body = preg_replace_callback(
    '/\b(href|src)=([\'"])([^\'"]+)\2/i',
    function ($m) use ($route_map) {
        $attr = $m[1];
        $quote = $m[2];
        $url = trim($m[3]);

        if ($url === '' || preg_match('#^(https?:|mailto:|tel:|javascript:|#)#i', $url)) {
            return $m[0];
        }

        $clean = ltrim($url, './');
        $lower = strtolower($clean);

        if (isset($route_map[$lower])) {
            return $attr . '=' . $quote . site_url($route_map[$lower]) . $quote;
        }

        if (preg_match('/\.(png|jpe?g|gif|svg|webp|ico|css|js|woff2?|ttf|eot|otf)$/i', $clean)) {
            return $attr . '=' . $quote . base_url($clean) . $quote;
        }

        return $m[0];
    },
    $body
);

echo $body;
