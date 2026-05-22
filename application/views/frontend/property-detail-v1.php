<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->helper('property'); ?>

<?php
$_all_imgs = [];
if (!empty($gallery_images)) {
    foreach ($gallery_images as $img) {
        $disk = FCPATH . ltrim(str_replace('\\','/',$img), '/');
        if (strpos($img,'http') === 0) {
            $_all_imgs[] = $img;
        } elseif (file_exists($disk)) {
            $_all_imgs[] = base_url($img);
        }
    }
}
if (empty($_all_imgs)) {
    $_all_imgs[] = get_property_image($property);
}
$_main_img   = $_all_imgs[0];
// price hidden per site requirement
$_process    = isset($property->process) ? $property->process : 'Upcoming';
$_proc_cls   = 'process-' . strtolower($_process);
$_video      = isset($property->video) ? trim($property->video) : '';
$_floorplan  = isset($property->floorplan) ? trim($property->floorplan) : '';

// Convert YouTube watch URL to embed URL
$_video_embed = '';
if (!empty($_video)) {
    if (preg_match('/[?&]v=([^&]+)/', $_video, $m)) {
        $_video_embed = 'https://www.youtube.com/embed/' . $m[1];
    } elseif (preg_match('/youtu\.be\/([^?]+)/', $_video, $m)) {
        $_video_embed = 'https://www.youtube.com/embed/' . $m[1];
    } elseif (strpos($_video, '/embed/') !== false) {
        $_video_embed = $_video;
    }
}
?>

<!-- Page Header -->
<div class="page-header bg-section parallaxie prop-detail-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="prop-detail-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque"><?php echo html_escape($property->name); ?></h1>
                    <?php if (!empty($property->location) || !empty($property->city)): ?>
                    <p class="prop-header-location">
                        <i class="fa-solid fa-location-dot"></i>
                        <?php echo html_escape($property->location); ?><?php echo !empty($property->city) ? ', ' . html_escape(trim($property->city)) : ''; ?>
                    </p>
                    <?php endif; ?>
                    <div class="prop-header-badges">
                        <span class="prop-status-badge <?php echo $_proc_cls; ?>"><?php echo html_escape($_process); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Property Detail Section -->
<?php $_is_bradhams = (stripos($property->name, 'bradham') !== false); ?>
<div class="property-detail-section<?php echo $_is_bradhams ? ' bradhams-detail' : ''; ?>">
    <div class="container">
        <div class="row">

            <!-- Main Content -->
            <div class="col-lg-8">

                <!-- ── GALLERY ── -->
                <div class="pd-block pd-gallery wow fadeInUp">
                    <div class="pd-gallery-main">
                        <img src="<?php echo $_main_img; ?>" id="gallery-main-img" alt="<?php echo html_escape($property->name); ?>">
                        <?php if (count($_all_imgs) > 1): ?>
                        <div class="gallery-count"><i class="fa-solid fa-image"></i> <?php echo count($_all_imgs); ?> Photos</div>
                        <?php endif; ?>
                    </div>
                    <?php if (count($_all_imgs) > 1): ?>
                    <div class="pd-gallery-thumbs">
                        <?php foreach ($_all_imgs as $idx => $gimg): ?>
                        <div class="pd-gallery-thumb <?php echo $idx === 0 ? 'active' : ''; ?>" onclick="switchGallery(this,'<?php echo $gimg; ?>')">
                            <img src="<?php echo $gimg; ?>" alt="">
                            <?php if ($idx === 0): ?><span class="thumb-active-bar"></span><?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- ── QUICK INFO ── -->
                <div class="pd-quick-info wow fadeInUp" data-wow-delay="0.1s">
                    <?php if (!empty($property->category)): ?>
                    <div class="pd-info-item">
                        <i class="fa-solid fa-layer-group"></i>
                        <div><span class="info-label">Category</span><span class="info-val"><?php echo html_escape($property->category); ?></span></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($property->type)): ?>
                    <div class="pd-info-item">
                        <i class="fa-solid fa-house"></i>
                        <div><span class="info-label">Type</span><span class="info-val"><?php echo html_escape(str_replace('_',' ',$property->type)); ?></span></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($property->total_plot)): ?>
                    <div class="pd-info-item">
                        <i class="fa-solid fa-ruler-combined"></i>
                        <div><span class="info-label">Total Plot</span><span class="info-val"><?php echo html_escape($property->total_plot); ?></span></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($property->available_size)): ?>
                    <div class="pd-info-item">
                        <i class="fa-solid fa-vector-square"></i>
                        <div><span class="info-label">Available Size</span><span class="info-val"><?php echo html_escape($property->available_size); ?></span></div>
                    </div>
                    <?php endif; ?>
                    <div class="pd-info-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div><span class="info-label">Status</span><span class="info-val"><?php echo html_escape($_process); ?></span></div>
                    </div>
                </div>

                <!-- ── DESCRIPTION ── -->
                <?php if (!empty($property->description)): ?>
                <div class="pd-block wow fadeInUp" data-wow-delay="0.1s">
                    <div class="pd-block-title"><h2>About This Property</h2></div>
                    <div class="pd-description"><?php echo $property->description; ?></div>
                </div>
                <?php endif; ?>

                <!-- ── FEATURES / AMENITIES ── -->
                <?php if (!empty($features)): ?>
                <div class="pd-block pd-amenities-block wow fadeInUp" data-wow-delay="0.15s">
                    <div class="pd-block-title"><h2>Features & Amenities</h2></div>
                    <div class="pd-amenities-grid">
                        <?php foreach ($features as $feat): if (!empty($feat['name'])): ?>
                        <div class="pd-amenity-card">
                            <?php if (!empty($feat['icon'])): ?>
                            <div class="pd-amenity-icon">
                                <img src="<?php echo base_url('assets/logos/' . rawurlencode($feat['icon'])); ?>"
                                     alt="<?php echo html_escape($feat['name']); ?>">
                            </div>
                            <?php else: ?>
                            <div class="pd-amenity-icon pd-amenity-icon--check">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <?php endif; ?>
                            <span class="pd-amenity-name"><?php echo html_escape($feat['name']); ?></span>
                        </div>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ── VIDEO ── -->
                <?php if (!empty($_video_embed)): ?>
                <div class="pd-block pd-video-block wow fadeInUp" data-wow-delay="0.2s">
                    <div class="pd-block-title"><h2><i class="fa-solid fa-circle-play"></i> Project Video</h2></div>
                    <div class="pd-video-wrap">
                        <iframe src="<?php echo html_escape($_video_embed); ?>?rel=0&modestbranding=1"
                            title="<?php echo html_escape($property->name); ?> – Project Video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ── FLOOR PLAN ── -->
                <?php if (!empty($_floorplan)): ?>
                <div class="pd-block pd-floorplan-block wow fadeInUp" data-wow-delay="0.22s">
                    <div class="pd-block-title"><h2><i class="fa-solid fa-drafting-compass"></i> Floor Plan</h2></div>
                    <div class="pd-floorplan-wrap">
                        <img src="<?php echo base_url($_floorplan); ?>" alt="Floor Plan – <?php echo html_escape($property->name); ?>" id="floorplan-img">
                        <a href="<?php echo base_url($_floorplan); ?>" target="_blank" class="floorplan-zoom-btn" title="View full size">
                            <i class="fa-solid fa-magnifying-glass-plus"></i> View Full Size
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ── NEARBY PLACES ── -->
                <?php if (!empty($nearby_places)): ?>
                <div class="pd-block pd-nearby-block wow fadeInUp" data-wow-delay="0.25s">
                    <div class="pd-block-title"><h2><i class="fa-solid fa-location-dot"></i> Nearby Places</h2></div>
                    <div class="pd-nearby-grid">
                        <?php foreach ($nearby_places as $place): ?>
                        <div class="pd-nearby-card">
                            <div class="nearby-icon"><i class="fa-solid fa-map-pin"></i></div>
                            <div class="nearby-info">
                                <?php if (is_array($place)): ?>
                                    <span class="nearby-name"><?php echo html_escape($place['title'] ?? ''); ?></span>
                                    <?php if (!empty($place['distance'])): ?>
                                    <span class="nearby-dist"><?php
                                        $d = html_escape($place['distance']);
                                        // append "km" only if no unit already present
                                        if (!preg_match('/(km|m\b|miles?|ft|meter)/i', $d)) $d .= ' km';
                                        echo $d;
                                    ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="nearby-name"><?php echo html_escape($place); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ── LOCATION MAP ── -->
                <?php
                $_map_embed  = '';
                $_map_raw    = !empty($property->location_url) ? trim($property->location_url) : '';
                if (!empty($_map_raw)) {
                    if (strpos($_map_raw, 'maps/embed') !== false || strpos($_map_raw, 'output=embed') !== false) {
                        // Already an embeddable URL
                        $_map_embed = $_map_raw;
                    } elseif (strpos($_map_raw, 'google.com/maps') !== false || strpos($_map_raw, 'maps.google.com') !== false) {
                        // Build embed URL from lat,lng coordinates
                        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $_map_raw, $_mc)) {
                            $_map_embed = 'https://maps.google.com/maps?q=' . $_mc[1] . ',' . $_mc[2] . '&hl=en&z=15&output=embed';
                        } else {
                            // Fallback: extract place name and build embed URL
                            preg_match('#maps/place/([^/@?&]+)#', $_map_raw, $_mc);
                            $q = !empty($_mc[1]) ? $_mc[1] : urlencode(!empty($property->location) ? $property->location . ' ' . $property->city : '');
                            $_map_embed = 'https://maps.google.com/maps?q=' . $q . '&hl=en&z=15&output=embed';
                        }
                    }
                }
                ?>
                <?php if (!empty($_map_embed)): ?>
                <div class="pd-block wow fadeInUp" data-wow-delay="0.3s">
                    <div class="pd-block-title"><h2><i class="fa-solid fa-map"></i> Location</h2></div>
                    <div class="pd-map-wrap">
                        <iframe src="<?php echo html_escape($_map_embed); ?>"
                                width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div style="text-align:right;margin-top:8px;">
                        <a href="<?php echo html_escape($_map_raw); ?>" target="_blank" rel="noopener"
                           style="font-size:13px;color:var(--secondary-color);font-weight:600;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> View on Google Maps
                        </a>
                    </div>
                </div>
                <?php elseif (!empty($property->location)): ?>
                <div class="pd-block wow fadeInUp" data-wow-delay="0.3s">
                    <div class="pd-block-title"><h2><i class="fa-solid fa-map"></i> Location</h2></div>
                    <div class="pd-location-text">
                        <i class="fa-solid fa-location-dot"></i>
                        <?php echo html_escape($property->location); ?><?php if (!empty($property->city)): ?>, <?php echo html_escape(trim($property->city)); ?><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <!-- Main Content End -->

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Enquiry Form -->
                <div class="pd-sidebar-card enquiry-card wow fadeInRight">
                    <div class="sidebar-head"><h3>Get More Info</h3><p>Interested? Send us an enquiry</p></div>
                    <form class="enquiry-form" id="prop-enquiry-form">
                        <input type="hidden" name="property_id" value="<?php echo $property->id; ?>">
                        <input type="hidden" name="property_name" value="<?php echo html_escape($property->name); ?>">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name *" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Your Email *" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4" placeholder="Your Message"><?php echo 'I am interested in ' . html_escape($property->name) . '. Please contact me.'; ?></textarea>
                        </div>
                        <button type="submit" class="btn-enquire"><i class="fa-solid fa-paper-plane"></i> Send Enquiry</button>
                        <div id="enquiry-msg" class="enquiry-feedback"></div>
                    </form>
                </div>

                <!-- Property Details -->
                <div class="pd-sidebar-card wow fadeInRight" data-wow-delay="0.1s">
                    <div class="sidebar-head"><h3>Property Details</h3></div>
                    <ul class="pd-summary-list">
                        <?php if (!empty($property->category)): ?>
                        <li><span>Category</span><strong><?php echo html_escape($property->category); ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($property->type)): ?>
                        <li><span>Type</span><strong><?php echo html_escape(str_replace('_',' ',$property->type)); ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($property->location)): ?>
                        <li><span>Location</span><strong><?php echo html_escape($property->location); ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($property->city)): ?>
                        <li><span>City</span><strong><?php echo html_escape(trim($property->city)); ?></strong></li>
                        <?php endif; ?>
                        <li><span>Status</span><strong class="prop-status-badge <?php echo $_proc_cls; ?>"><?php echo html_escape($_process); ?></strong></li>
                    </ul>
                </div>

                <!-- Latest Properties -->
                <?php if (!empty($latest_properties)): ?>
                <div class="pd-sidebar-card wow fadeInRight" data-wow-delay="0.2s">
                    <div class="sidebar-head"><h3>Latest Properties</h3></div>
                    <ul class="pd-related-list">
                        <?php foreach ($latest_properties as $rp): if ($rp->id == $property->id) continue; ?>
                        <?php $rp_img = get_property_image($rp); $rp_url = get_property_url($rp); ?>
                        <li>
                            <a href="<?php echo $rp_url; ?>" class="related-item">
                                <div class="related-thumb">
                                    <img src="<?php echo $rp_img; ?>" alt="<?php echo html_escape($rp->name); ?>">
                                </div>
                                <div class="related-info">
                                    <h4><?php echo html_escape($rp->name); ?></h4>
                                    <?php if (!empty($rp->location)): ?>
                                    <small><i class="fa-solid fa-location-dot"></i> <?php echo html_escape($rp->location); ?></small>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
            <!-- Sidebar End -->

        </div>
    </div>
</div>

<style>
/* ===== PAGE HEADER ===== */
.prop-detail-header .container {
    position: relative;
    z-index: 3;
    text-align: center;
}
.prop-detail-header .prop-detail-header-box {
    display: inline-block;
    text-align: center;
    background: rgba(4, 6, 24, 0.60);
    border-radius: 12px;
    padding: 30px 48px;
    max-width: 700px;
    position: relative;
    z-index: 3;
}
.prop-detail-header .prop-detail-header-box h1,
.prop-detail-header .prop-detail-header-box h1 *,
.prop-detail-header .prop-detail-header-box h1 span {
    color: #fff !important;
    font-weight: 800 !important;
    margin-bottom: 14px;
}
.prop-header-location {
    color: #fff !important;
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}
.prop-header-location i { color: #fff !important; }
.prop-header-badges {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}
.prop-price-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.25);
}
.prop-price-badge i { color: var(--secondary-color); }
.prop-status-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.process-ongoing   { background: var(--primary-color); color: var(--white-color); }
.process-upcoming  { background: var(--accent-color); color: var(--white-color); }
.process-completed { background: var(--secondary-color); color: var(--white-color); }

/* ===== LAYOUT ===== */
.property-detail-section { padding: 60px 0; background: #f4f5f7; }

/* ===== SHARED BLOCK ===== */
.pd-block {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    margin-bottom: 24px;
}
.pd-block-title {
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 2px solid var(--secondary-color);
}
.pd-block-title h2 {
    font-size: 19px;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.pd-block-title h2 i { color: var(--secondary-color); font-size: 18px; }

/* ===== GALLERY ===== */
.pd-gallery { padding: 0; overflow: hidden; }
.pd-gallery-main { position: relative; }
#gallery-main-img {
    width: 100%;
    height: 440px;
    object-fit: cover;
    display: block;
    transition: opacity 0.25s;
}
.gallery-count {
    position: absolute;
    bottom: 14px;
    right: 14px;
    background: rgba(0,0,0,0.55);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(4px);
}
.pd-gallery-thumbs {
    display: flex;
    gap: 8px;
    padding: 14px 16px;
    flex-wrap: wrap;
    background: #fff;
}
.pd-gallery-thumb {
    position: relative;
    width: 84px;
    height: 62px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2.5px solid transparent;
    transition: border-color 0.2s, transform 0.2s;
    flex-shrink: 0;
}
.pd-gallery-thumb.active { border-color: var(--secondary-color); }
.pd-gallery-thumb:hover { transform: translateY(-2px); }
.pd-gallery-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* ===== QUICK INFO ===== */
.pd-quick-info {
    display: flex;
    background: var(--primary-color);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}
.pd-info-item {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 16px;
    border-right: 1px solid rgba(255,255,255,0.07);
}
.pd-info-item:last-child { border-right: none; }
.pd-info-item > i { font-size: 22px; color: var(--secondary-color); flex-shrink: 0; }
.info-label { display: block; font-size: 11px; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.5px; }
.info-val   { display: block; font-size: 14px; font-weight: 700; color: #fff; margin-top: 2px; }

/* ===== DESCRIPTION ===== */
.pd-description { font-size: 15px; line-height: 1.85; color: #555; }
.pd-description p { margin-bottom: 14px; }

/* ===== FEATURES ===== */
.pd-features-grid {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 10px;
}
.pd-features-grid li {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 14px;
    color: #444;
    background: #f8f9fa;
    padding: 9px 14px;
    border-radius: 8px;
}
.pd-features-grid li i { color: var(--secondary-color); font-size: 14px; flex-shrink: 0; }

/* ===== VIDEO ===== */
.pd-video-wrap {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: 12px;
    background: #000;
}
.pd-video-wrap iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border-radius: 12px;
}

/* ===== FLOOR PLAN ===== */
.pd-floorplan-wrap {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}
.pd-floorplan-wrap img {
    width: 100%;
    display: block;
    border-radius: 12px;
}
.floorplan-zoom-btn {
    position: absolute;
    bottom: 16px;
    right: 16px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(4,6,24,0.8);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 9px 18px;
    border-radius: 50px;
    text-decoration: none;
    transition: background 0.3s;
}
.floorplan-zoom-btn:hover { background: var(--secondary-color); color: var(--primary-color); }
.floorplan-zoom-btn i { font-size: 14px; }

/* ===== AMENITIES ===== */
.pd-amenities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 16px;
}
.pd-amenity-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 18px 12px;
    text-align: center;
    transition: box-shadow 0.2s, transform 0.2s;
}
.pd-amenity-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.09); transform: translateY(-2px); }
.pd-amenity-icon { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
.pd-amenity-icon img { width: 100%; height: 100%; object-fit: contain; }
.pd-amenity-icon--check { background: var(--secondary-color); border-radius: 10px; width: 40px; height: 40px; }
.pd-amenity-icon--check i { color: var(--primary-color); font-size: 18px; }
.pd-amenity-name { font-size: 12px; font-weight: 600; color: var(--primary-color); line-height: 1.3; }

/* ===== NEARBY ===== */
.pd-nearby-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.pd-nearby-card {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px 18px;
    border-left: 3px solid var(--secondary-color);
    transition: box-shadow 0.2s, transform 0.2s;
}
.pd-nearby-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.09); transform: translateY(-2px); }
.nearby-icon {
    width: 40px;
    height: 40px;
    background: var(--secondary-color);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.nearby-icon i { color: var(--primary-color); font-size: 16px; }
.nearby-info { flex: 1; min-width: 0; }
.nearby-name { display: block; font-size: 14px; font-weight: 600; color: var(--primary-color); line-height: 1.3; margin-bottom: 5px; }
.nearby-dist {
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    background: var(--primary-color);
    color: var(--secondary-color);
    padding: 3px 10px;
    border-radius: 50px;
}

/* ===== MAP ===== */
.pd-map-wrap iframe { border-radius: 12px; display: block; }
.pd-location-text {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    color: #555;
    background: #f8f9fa;
    padding: 14px 18px;
    border-radius: 10px;
}
.pd-location-text i { color: var(--secondary-color); font-size: 16px; }

/* ===== SIDEBAR ===== */
.pd-sidebar-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 24px;
}
.sidebar-head {
    background: var(--primary-color);
    padding: 18px 22px;
}
.sidebar-head h3 { color: #fff; font-size: 16px; font-weight: 700; margin: 0 0 3px; }
.sidebar-head p  { color: rgba(255,255,255,0.55); font-size: 13px; margin: 0; }

.enquiry-form { padding: 20px 22px; }
.enquiry-form .form-group { margin-bottom: 12px; }
.enquiry-form .form-control {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid #e5e5e5; border-radius: 8px;
    font-size: 14px; color: #444; background: #fafafa;
    transition: border-color 0.2s;
}
.enquiry-form .form-control:focus { border-color: var(--secondary-color); outline: none; background: #fff; }
.enquiry-form textarea.form-control { resize: vertical; min-height: 88px; }
.btn-enquire {
    width: 100%; padding: 13px;
    background: var(--primary-color); color: var(--secondary-color);
    border: none; border-radius: 8px;
    font-size: 15px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.3s;
}
.btn-enquire:hover { background: var(--secondary-color); color: var(--primary-color); }
.enquiry-feedback { margin-top: 10px; text-align: center; font-size: 14px; font-weight: 600; padding: 8px; border-radius: 6px; display: none; }
.enquiry-feedback.success { background: #e8f5e9; color: var(--secondary-color); display: block; }
.enquiry-feedback.error   { background: #fdecea; color: #e53935; display: block; }

.pd-summary-list { list-style: none; padding: 16px 22px; margin: 0; }
.pd-summary-list li { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
.pd-summary-list li:last-child { border-bottom: none; }
.pd-summary-list span { color: #888; }
.pd-summary-list strong { color: #d1ab85; font-weight: 700; text-align: right; }

.pd-related-list { list-style: none; padding: 14px 18px; margin: 0; display: flex; flex-direction: column; gap: 14px; }
.related-item { display: flex; gap: 12px; text-decoration: none; }
.related-thumb { width: 70px; height: 58px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
.related-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.related-item:hover .related-thumb img { transform: scale(1.08); }
.related-info { flex: 1; min-width: 0; }
.related-info h4 { font-size: 13px; font-weight: 700; color: var(--primary-color); margin: 0 0 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.related-item:hover h4 { color: var(--secondary-color); }
.related-info span { font-size: 14px; font-weight: 800; color: var(--primary-color); display: block; }
.related-info small { font-size: 12px; color: #888; display: flex; align-items: center; gap: 4px; margin-top: 2px; }
.related-info small i { color: var(--secondary-color); font-size: 11px; }

@media (max-width: 991px) {
    #gallery-main-img { height: 300px; }
    .pd-quick-info { flex-wrap: wrap; }
    .pd-info-item { min-width: 45%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
    .pd-nearby-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 575px) {
    #gallery-main-img { height: 220px; }
    .pd-info-item { min-width: 100%; }
    .pd-nearby-grid { grid-template-columns: 1fr; }
    .pd-features-grid { grid-template-columns: 1fr; }
}

/* ===== BRADHAMS BLOCK COLOR ===== */
.bradhams-detail .pd-block {
    background: #fff;
    border-radius: 0;
    padding: 0;
    box-shadow: none;
    border: 2px solid var(--primary-color);
    overflow: hidden;
}
.bradhams-detail .pd-block-title {
    margin-bottom: 0;
    padding: 14px 24px;
    background: var(--primary-color);
    border-bottom: none;
}
.bradhams-detail .pd-block-title h2 {
    font-size: 15px;
    font-weight: 800;
    color: var(--secondary-color);
    text-transform: uppercase;
    letter-spacing: 1px;
}
.bradhams-detail .pd-block-title h2 i { color: var(--secondary-color); font-size: 15px; }
.bradhams-detail .pd-gallery { border: 2px solid var(--primary-color); }
.bradhams-detail .gallery-count {
    bottom: 0; right: 0; border-radius: 0;
    background: var(--secondary-color); color: var(--primary-color); font-weight: 800;
    backdrop-filter: none;
}
.bradhams-detail .pd-gallery-thumbs { background: var(--primary-color); gap: 6px; padding: 10px 12px; }
.bradhams-detail .pd-gallery-thumb { border-radius: 0; border-width: 3px; }
.bradhams-detail .pd-gallery-thumb:hover { transform: none; border-color: var(--secondary-color); }
.bradhams-detail .pd-quick-info {
    background: var(--secondary-color); border-radius: 0;
    border: 2px solid var(--primary-color); box-shadow: none;
}
.bradhams-detail .pd-info-item { border-right: 2px solid var(--primary-color); }
.bradhams-detail .pd-info-item > i { color: var(--primary-color); }
.bradhams-detail .info-label { color: var(--primary-color); opacity: 0.6; font-weight: 700; }
.bradhams-detail .info-val { color: var(--primary-color); font-weight: 800; }
.bradhams-detail .pd-description { padding: 24px; }
.bradhams-detail .pd-amenities-grid { padding: 20px 24px 24px; gap: 8px; }
.bradhams-detail .pd-amenity-card {
    background: var(--primary-color); border-radius: 0;
    padding: 12px; border-left: none;
}
.bradhams-detail .pd-amenity-card:hover { box-shadow: none; transform: none; opacity: 0.85; }
.bradhams-detail .pd-amenity-name { color: var(--secondary-color); font-weight: 800; font-size: 11px; text-transform: uppercase; }
.bradhams-detail .pd-amenity-icon--check { background: var(--secondary-color); border-radius: 0; }
.bradhams-detail .pd-amenity-icon--check i { color: var(--primary-color); }
.bradhams-detail .pd-video-wrap { border-radius: 0; margin: 0 24px 24px; }
.bradhams-detail .pd-video-wrap iframe { border-radius: 0; }
.bradhams-detail .pd-floorplan-wrap { border-radius: 0; margin: 0 24px 24px; }
.bradhams-detail .pd-floorplan-wrap img { border-radius: 0; }
.bradhams-detail .floorplan-zoom-btn {
    bottom: 0; right: 0; border-radius: 0;
    background: var(--secondary-color); color: var(--primary-color);
    font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
    backdrop-filter: none;
}
.bradhams-detail .floorplan-zoom-btn:hover { background: var(--primary-color); color: var(--secondary-color); }
.bradhams-detail .pd-nearby-grid { padding: 20px 24px 24px; gap: 8px; }
.bradhams-detail .pd-nearby-card {
    background: var(--primary-color); border-radius: 0;
    padding: 0; border-left: none; gap: 0; align-items: stretch;
}
.bradhams-detail .pd-nearby-card:hover { box-shadow: none; transform: none; opacity: 0.85; }
.bradhams-detail .nearby-icon {
    width: 50px; border-radius: 0; background: var(--secondary-color); align-self: stretch; height: auto;
}
.bradhams-detail .nearby-icon i { color: var(--primary-color); font-size: 18px; }
.bradhams-detail .nearby-info { padding: 12px 14px; }
.bradhams-detail .nearby-name { color: #fff; font-weight: 800; font-size: 12px; text-transform: uppercase; }
.bradhams-detail .nearby-dist {
    background: var(--secondary-color); color: var(--primary-color);
    border-radius: 0; font-weight: 800; font-size: 11px;
}
.bradhams-detail .pd-map-wrap { padding: 0 24px 24px; }
.bradhams-detail .pd-map-wrap iframe { border-radius: 0; }
.bradhams-detail .pd-location-text {
    background: var(--primary-color); color: var(--secondary-color);
    border-radius: 0; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.5px; font-size: 13px; margin: 0 24px 24px;
}
.bradhams-detail .pd-sidebar-card {
    border-radius: 0; box-shadow: none; border: 2px solid var(--primary-color);
}
.bradhams-detail .sidebar-head h3 {
    color: var(--secondary-color); font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px; font-size: 14px;
}
.bradhams-detail .enquiry-form .form-control {
    border: 2px solid var(--primary-color); border-radius: 0;
    background: #fff; font-weight: 600;
}
.bradhams-detail .btn-enquire {
    background: var(--secondary-color); color: var(--primary-color);
    border-radius: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
}
.bradhams-detail .btn-enquire:hover { background: var(--primary-color); color: var(--secondary-color); }
.bradhams-detail .enquiry-feedback { border-radius: 0; font-weight: 800; text-transform: uppercase; }
.bradhams-detail .enquiry-feedback.success { background: var(--secondary-color); color: var(--primary-color); }
.bradhams-detail .pd-summary-list { padding: 0 22px; }
.bradhams-detail .pd-summary-list span { text-transform: uppercase; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
.bradhams-detail .pd-summary-list strong { color: var(--primary-color); font-weight: 800; }
.bradhams-detail .pd-related-list { gap: 8px; }
.bradhams-detail .related-item {
    border: 2px solid var(--primary-color); gap: 0; border-radius: 0;
}
.bradhams-detail .related-thumb { border-radius: 0; width: 72px; }
.bradhams-detail .related-info { padding: 8px 12px; transition: background 0.2s; }
.bradhams-detail .related-info h4 { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3px; }
.bradhams-detail .related-item:hover .related-info { background: var(--secondary-color); }
.bradhams-detail .related-item:hover h4 { color: var(--primary-color); }
.bradhams-detail .property-detail-section { background: #fff; }
</style>

<script>
function switchGallery(thumb, imgSrc) {
    var mainImg = document.getElementById('gallery-main-img');
    mainImg.style.opacity = '0.4';
    setTimeout(function() {
        mainImg.src = imgSrc;
        mainImg.style.opacity = '1';
    }, 180);
    document.querySelectorAll('.pd-gallery-thumb').forEach(function(t) { t.classList.remove('active'); });
    thumb.classList.add('active');
}

document.getElementById('prop-enquiry-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = this.querySelector('.btn-enquire');
    var msg = document.getElementById('enquiry-msg');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

    fetch('<?php echo site_url('api/enquiry_store'); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(new FormData(this)).toString()
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            msg.className = 'enquiry-feedback success';
            msg.textContent = 'Thank you! We will contact you soon.';
        } else { throw new Error(); }
    })
    .catch(function() {
        msg.className = 'enquiry-feedback success';
        msg.textContent = 'Thank you! We will contact you soon.';
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Enquiry';
    });
});
</script>
