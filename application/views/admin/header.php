<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Property Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .stat-card.primary { border-left: 4px solid #667eea; }
        .stat-card.success { border-left: 4px solid #28a745; }
        .stat-card.info { border-left: 4px solid #17a2b8; }
        .stat-card.warning { border-left: 4px solid #ffc107; }

        
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="text-center mb-4">
            <h4><i class="fas fa-building me-2"></i>Admin Panel</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link <?php echo (uri_string() == 'admin/dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('admin/dashboard'); ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/properties') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/properties'); ?>">
                <i class="fas fa-home me-2"></i>Properties
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/banners') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/banners'); ?>">
                <i class="fas fa-images me-2"></i>Banners
            </a>
            <!-- <a class="nav-link <?php echo (strpos(uri_string(), 'admin/offer_banners') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/offer_banners'); ?>">
                <i class="fas fa-gift me-2"></i>Offer Banners
            </a> -->
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/cities') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/cities'); ?>">
                <i class="fas fa-city me-2"></i>Cities
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/locations') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/locations'); ?>">
                <i class="fas fa-map-marker-alt me-2"></i>Locations
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/categories') !== false || strpos(uri_string(), 'admin/category_') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/categories'); ?>">
                <i class="fas fa-tags me-2"></i>Categories
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/blogs') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/blogs'); ?>">
                <i class="fas fa-blog me-2"></i>Blogs
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/testimonial') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/testimonials'); ?>">
                <i class="fas fa-star me-2"></i>Testimonials
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/amenities') !== false || strpos(uri_string(), 'admin/amenity_') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/amenities'); ?>">
                <i class="fas fa-star-of-life me-2"></i>Amenities
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/enquiries') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/enquiries'); ?>">
                <i class="fas fa-envelope me-2"></i>Enquiries
                <?php if (!empty($new_enquiries) && $new_enquiries > 0): ?>
                <span class="badge bg-danger ms-1"><?php echo $new_enquiries; ?></span>
                <?php endif; ?>
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/contacts') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/contacts'); ?>">
                <i class="fas fa-address-book me-2"></i>Contacts
            </a>
            <a class="nav-link <?php echo (strpos(uri_string(), 'admin/seo') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/seo'); ?>">
                <i class="fas fa-search me-2"></i>SEO Settings
            </a>
            <a class="nav-link" href="<?php echo base_url('admin/logout'); ?>">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </nav>
    </div>
    <div class="main-content">
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Welcome, <?php echo $this->session->userdata('admin_username'); ?></span>
            </div>
        </nav>

