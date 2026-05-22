<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$status  = isset($project_status) ? $project_status : 'all';
$filters = isset($filters) ? $filters : array('category'=>'','city'=>'','location'=>'');
$f_cat   = isset($filters['category']) ? $filters['category'] : '';
$f_city  = isset($filters['city'])     ? $filters['city']     : '';
$f_loc   = isset($filters['location']) ? $filters['location'] : '';

// Build current status base URL for form action
$status_urls = array(
    'all'       => site_url('projects'),
    'ongoing'   => site_url('projects/ongoing'),
    'upcoming'  => site_url('projects/upcoming'),
    'completed' => site_url('projects/completed'),
);
$form_action = isset($status_urls[$status]) ? $status_urls[$status] : site_url('projects');

// Build tab URLs preserving active filters
function tab_url($base, $f_cat, $f_city, $f_loc) {
    $q = array();
    if (!empty($f_cat)) $q[] = 'category=' . urlencode($f_cat);
    if (!empty($f_city)) $q[] = 'city=' . urlencode($f_city);
    if (!empty($f_loc)) $q[] = 'location=' . urlencode($f_loc);
    return $base . (!empty($q) ? '?' . implode('&', $q) : '');
}

$has_filter = !empty($f_cat) || !empty($f_city) || !empty($f_loc);
?>

<!-- Page Header -->
<div class="page-header bg-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">Our <span>projects</span></h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Projects -->
<div class="page-projects">
    <div class="container">

        <!-- ── SEARCH BAR ── -->
        <div class="proj-search-bar wow fadeInUp">
            <form method="GET" action="<?php echo $form_action; ?>" id="proj-search-form">
                <div class="proj-search-fields">

                    <div class="proj-search-field">
                        <label><i class="fa-solid fa-layer-group"></i> Category</label>
                        <select name="category" id="sel-category">
                            <option value="">All Categories</option>
                            <?php if (!empty($categories)): foreach ($categories as $cat): ?>
                            <option value="<?php echo html_escape($cat->category_name); ?>"
                                <?php echo ($f_cat === $cat->category_name) ? 'selected' : ''; ?>>
                                <?php echo html_escape($cat->category_name); ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="proj-search-divider"></div>

                    <div class="proj-search-field">
                        <label><i class="fa-solid fa-city"></i> City</label>
                        <select name="city" id="sel-city">
                            <option value="">All Cities</option>
                            <?php if (!empty($cities)): foreach ($cities as $city): ?>
                            <option value="<?php echo html_escape($city->name); ?>"
                                data-id="<?php echo $city->id; ?>"
                                <?php echo ($f_city === $city->name) ? 'selected' : ''; ?>>
                                <?php echo html_escape($city->name); ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="proj-search-divider"></div>

                    <div class="proj-search-field">
                        <label><i class="fa-solid fa-location-dot"></i> Location</label>
                        <select name="location" id="sel-location">
                            <option value="">All Locations</option>
                            <?php if (!empty($locations)): foreach ($locations as $loc): ?>
                            <option value="<?php echo html_escape($loc->name); ?>"
                                data-city-id="<?php echo $loc->city_id; ?>"
                                <?php echo ($f_loc === $loc->name) ? 'selected' : ''; ?>>
                                <?php echo html_escape($loc->name); ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <button type="submit" class="proj-search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>

                    <?php if ($has_filter): ?>
                    <a href="<?php echo $form_action; ?>" class="proj-clear-btn" title="Clear filters">
                        <i class="fa-solid fa-xmark"></i> Clear
                    </a>
                    <?php endif; ?>

                </div>
            </form>
        </div>

        <!-- ── STATUS TABS ── -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <ul class="project-filter-tabs">
                    <li><a class="filter-tab <?php echo ($status==='all')       ? 'active':'' ?>" href="<?php echo tab_url(site_url('projects'),          $f_cat,$f_city,$f_loc); ?>">All</a></li>
                    <li><a class="filter-tab <?php echo ($status==='ongoing')   ? 'active':'' ?>" href="<?php echo tab_url(site_url('projects/ongoing'),   $f_cat,$f_city,$f_loc); ?>">Ongoing</a></li>
                    <li><a class="filter-tab <?php echo ($status==='upcoming')  ? 'active':'' ?>" href="<?php echo tab_url(site_url('projects/upcoming'),  $f_cat,$f_city,$f_loc); ?>">Upcoming</a></li>
                    <li><a class="filter-tab <?php echo ($status==='completed') ? 'active':'' ?>" href="<?php echo tab_url(site_url('projects/completed'), $f_cat,$f_city,$f_loc); ?>">Completed</a></li>
                </ul>
            </div>
        </div>

        <!-- Result count -->
        <?php if ($has_filter): ?>
        <div class="proj-result-info wow fadeInUp mb-3">
            <p>
                <?php echo count($properties); ?> project<?php echo count($properties) !== 1 ? 's' : ''; ?> found
                <?php if (!empty($f_cat)):  ?> in <strong><?php echo html_escape($f_cat); ?></strong><?php endif; ?>
                <?php if (!empty($f_city)): ?>, <strong><?php echo html_escape($f_city); ?></strong><?php endif; ?>
                <?php if (!empty($f_loc)):  ?> – <strong><?php echo html_escape($f_loc); ?></strong><?php endif; ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- ── PROPERTIES GRID ── -->
        <div class="row">
            <?php if (!empty($properties)): ?>
                <?php $delay = 0; foreach ($properties as $prop): ?>
                <?php
                $img_url  = get_property_image($prop);
                $prop_url = get_property_url($prop);
                ?>
                <div class="col-xl-3 col-md-6">
                    <div class="project-item wow fadeInUp" <?php echo $delay > 0 ? 'data-wow-delay="'.$delay.'s"' : ''; ?>>

                        <div class="project-item-image">
                            <a href="<?php echo $prop_url; ?>" data-cursor-text="View">
                                <figure>
                                    <img src="<?php echo $img_url; ?>" alt="<?php echo html_escape($prop->name); ?>">
                                </figure>
                            </a>
                            <span class="project-process-badge <?php echo get_process_badge($prop->process); ?>">
                                <?php echo html_escape($prop->process); ?>
                            </span>
                        </div>

                        <div class="project-item-content">
                            <?php if (!empty($prop->category)): ?>
                            <ul><li><?php echo html_escape($prop->category); ?></li></ul>
                            <?php endif; ?>
                            <h2><a href="<?php echo $prop_url; ?>"><?php echo html_escape($prop->name); ?></a></h2>
                            <?php if (!empty($prop->location)): ?>
                            <div class="project-item-meta">
                                <span><i class="fa-solid fa-location-dot"></i> <?php echo html_escape($prop->location); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php $delay = round($delay + 0.2, 1); endforeach; ?>

            <?php else: ?>
                <div class="col-lg-12">
                    <div class="no-projects-found">
                        <i class="fa-solid fa-folder-open"></i>
                        <h3>No projects found</h3>
                        <p>Try adjusting your search filters.</p>
                        <a class="filter-tab active" href="<?php echo site_url('projects'); ?>">View All Projects</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
/* ── Search Bar ── */
.proj-search-bar {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    padding: 24px 28px;
    margin-bottom: 30px;
}
.proj-search-fields {
    display: flex;
    align-items: flex-end;
    gap: 0;
    flex-wrap: wrap;
}
.proj-search-field {
    flex: 1;
    min-width: 160px;
    padding: 0 18px;
}
.proj-search-field:first-child { padding-left: 0; }
.proj-search-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}
.proj-search-field label i { color: var(--secondary-color); font-size: 13px; }
.proj-search-field select {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e8e8e8;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    background: #fafafa;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    cursor: pointer;
    transition: border-color 0.2s;
}
.proj-search-field select:focus { outline: none; border-color: var(--primary-color); }
.proj-search-divider {
    width: 1px;
    height: 44px;
    background: #e8e8e8;
    align-self: flex-end;
    margin-bottom: 1px;
    flex-shrink: 0;
}
.proj-search-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-color);
    color: var(--secondary-color);
    border: none;
    border-radius: 8px;
    padding: 12px 26px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.3s;
    margin-left: 18px;
    white-space: nowrap;
    flex-shrink: 0;
}
.proj-search-btn:hover { background: var(--secondary-color); color: var(--white-color); }
.proj-clear-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #888;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    padding: 12px 10px;
    border-radius: 8px;
    transition: color 0.2s;
    white-space: nowrap;
    flex-shrink: 0;
}
.proj-clear-btn:hover { color: #e53935; }

/* Result info */
.proj-result-info p { font-size: 14px; color: #666; margin: 0; }
.proj-result-info strong { color: var(--primary-color); }

/* ── Filter Tabs ── */
.project-filter-tabs {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.filter-tab {
    display: inline-block;
    padding: 10px 28px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    text-decoration: none;
    background: var(--primary-color);
    color: var(--white-color);
    border: 2px solid var(--primary-color);
    transition: all 0.3s ease;
    cursor: pointer;
}
.filter-tab:hover,
.filter-tab.active {
    background: var(--secondary-color);
    color: var(--white-color);
    border-color: var(--secondary-color);
}

/* ── Project Cards ── */
.project-item {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 30px;
    height: calc(100% - 30px);
}
.project-item-image {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}
.project-item-image figure {
    position: relative;
    display: block;
    margin: 0;
    border-radius: 20px;
    overflow: hidden;
}
.project-item-image figure::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 20px;
    background: linear-gradient(180deg, transparent 45%, var(--secondary-color) 95%);
    z-index: 1;
}
.project-item-image img {
    width: 100%;
    aspect-ratio: 1 / 1.35;
    object-fit: cover;
    border-radius: 20px;
    transition: transform 0.6s ease-in-out;
    display: block;
}
.project-item:hover .project-item-image img { transform: scale(1.06); }

.project-process-badge {
    position: absolute;
    top: 14px; left: 14px;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 11px; font-weight: 700;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    z-index: 2;
}
.badge-ongoing   { background: var(--primary-color); color: var(--white-color); }
.badge-upcoming  { background: var(--accent-color); color: var(--white-color); }
.badge-completed { background: var(--secondary-color); color: var(--white-color); }

.project-item-content {
    position: absolute;
    left: 24px; right: 24px; bottom: 24px;
    z-index: 2;
}
.project-item-content ul { list-style:none; padding:0; margin:0 0 8px; display:flex; gap:8px; }
.project-item-content ul li {
    position: relative;
    font-size: 13px; font-weight: 600;
    color: var(--white-color); padding-left: 14px;
    text-transform: uppercase; letter-spacing: 0.8px;
}
.project-item-content ul li::before {
    content: '';
    position: absolute;
    top: 50%; left: 0;
    transform: translateY(-50%);
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--secondary-color);
}
.project-item-content h2 { font-size:18px; font-weight:700; line-height:1.4; margin:0 0 8px; color:#fff; }
.project-item-content h2 a { color:inherit; text-decoration:none; transition:color 0.3s; }
.project-item-content h2 a:hover { color: var(--secondary-color); }
.project-item-meta { display:flex; flex-wrap:wrap; gap:12px; }
.project-item-meta span { font-size:12px; color:rgba(255,255,255,0.85); display:flex; align-items:center; gap:5px; }
.project-item-meta span i { color: var(--secondary-color); font-size:11px; }

/* Empty State */
.no-projects-found { text-align:center; padding:80px 0; }
.no-projects-found i { font-size:48px; color:#ddd; display:block; margin-bottom:20px; }
.no-projects-found h3 { color:#555; margin-bottom:10px; }
.no-projects-found p { color:#888; margin-bottom:20px; }

@media (max-width: 991px) {
    .proj-search-fields { gap: 12px; }
    .proj-search-divider { display: none; }
    .proj-search-field { padding: 0; min-width: calc(50% - 6px); }
    .proj-search-btn { margin-left: 0; width: 100%; justify-content: center; }
    .proj-clear-btn { width: 100%; justify-content: center; }
}
@media (max-width: 575px) {
    .proj-search-bar { padding: 18px; }
    .proj-search-field { min-width: 100%; }
    .project-item-content { left: 16px; right: 16px; bottom: 16px; }
    .project-item-content h2 { font-size: 16px; }
}
</style>

<script>
(function(){
    // Location filter: hide options not matching selected city
    var selCity = document.getElementById('sel-city');
    var selLoc  = document.getElementById('sel-location');
    var allLocs = Array.from(selLoc.options).slice(1); // skip "All Locations"

    function filterLocations() {
        var cityVal = selCity.options[selCity.selectedIndex];
        var cityId  = cityVal ? cityVal.getAttribute('data-id') : '';

        // Remove all except first
        while (selLoc.options.length > 1) selLoc.remove(1);

        allLocs.forEach(function(opt) {
            if (!cityId || opt.getAttribute('data-city-id') === cityId) {
                selLoc.appendChild(opt.cloneNode(true));
            }
        });

        // Re-select if still valid
        var locVal = '<?php echo addslashes($f_loc); ?>';
        Array.from(selLoc.options).forEach(function(o){ if(o.value===locVal) o.selected=true; });
    }

    selCity.addEventListener('change', function() {
        selLoc.value = '';
        filterLocations();
    });

    // Run on load to filter locs based on pre-selected city
    filterLocations();
})();
</script>
