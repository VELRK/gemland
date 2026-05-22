<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header Section Start -->
<div class="page-header bg-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">Property <span>Listing</span></h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Properties</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header Section End -->

<!-- Property Listing Section Start -->
<div class="property-listing-section">
    <div class="container">
        <div class="row">

            <!-- Filter Sidebar (hidden) -->
            <div class="col-lg-3" style="display:none;">
                <div class="listing-filter-box wow fadeInLeft">
                    <div class="filter-header">
                        <h3><i class="fa-solid fa-sliders"></i> Filter Properties</h3>
                    </div>

                    <div class="filter-body">

                        <!-- City Filter -->
                        <div class="filter-group">
                            <label class="filter-label">City</label>
                            <select id="filter-city" class="filter-select">
                                <option value="">All Cities</option>
                                <?php foreach ($cities as $city): ?>
                                <option value="<?php echo html_escape($city->name); ?>">
                                    <?php echo html_escape(trim($city->name)); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div class="filter-group">
                            <label class="filter-label">Location</label>
                            <select id="filter-location" class="filter-select">
                                <option value="">All Locations</option>
                                <?php foreach ($locations as $loc): ?>
                                <option value="<?php echo html_escape($loc->name); ?>"
                                        data-city="<?php echo html_escape(trim($loc->city_name)); ?>">
                                    <?php echo html_escape($loc->name); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <?php if (!empty($categories)): ?>
                        <div class="filter-group">
                            <label class="filter-label">Category</label>
                            <select id="filter-category" class="filter-select">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo html_escape($cat->category_name); ?>">
                                    <?php echo html_escape($cat->category_name); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Sort By -->
                        <div class="filter-group">
                            <label class="filter-label">Sort By</label>
                            <select id="filter-sort" class="filter-select">
                                <option value="newest">Newest First</option>
                                <option value="featured">Featured</option>
                            </select>
                        </div>

                        <!-- Apply / Reset Buttons -->
                        <div class="filter-actions">
                            <button id="btn-apply-filter" class="btn-filter-apply">
                                <i class="fa-solid fa-magnifying-glass"></i> Search
                            </button>
                            <button id="btn-reset-filter" class="btn-filter-reset">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Filter Sidebar End -->

            <!-- Properties Grid Start -->
            <div class="col-lg-12">

                <!-- Results Bar -->
                <div class="listing-results-bar wow fadeInUp">
                    <span id="results-count">Loading properties...</span>
                    <div class="listing-view-toggle">
                        <button class="view-btn active" id="view-grid" title="Grid View">
                            <i class="fa-solid fa-grid-2"></i>
                        </button>
                        <button class="view-btn" id="view-list" title="List View">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                </div>

                <!-- Properties Output -->
                <div id="properties-grid" class="properties-grid-view">
                    <!-- AJAX loaded -->
                    <div class="listing-loading">
                        <div class="loading-spinner"></div>
                        <p>Loading properties...</p>
                    </div>
                </div>

            </div>
            <!-- Properties Grid End -->

        </div>
    </div>
</div>
<!-- Property Listing Section End -->

<style>
/* Listing Page */
.property-listing-section {
    padding: 70px 0;
    background: var(--bg-color);
}

/* Filter Box */
.listing-filter-box {
    background: var(--white-color);
    border-radius: 14px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.07);
    overflow: hidden;
    position: sticky;
    top: 100px;
}
.filter-header {
    background: var(--primary-color);
    padding: 18px 24px;
}
.filter-header h3 {
    color: var(--white-color);
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.filter-header h3 i { color: var(--primary-color); }
.filter-body { padding: 20px 24px 24px; }

.filter-group { margin-bottom: 18px; }
.filter-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.filter-select {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--divider-color);
    border-radius: 8px;
    font-size: 14px;
    color: var(--text-color);
    background: var(--white-color);
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23666' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    cursor: pointer;
    transition: border-color 0.2s;
}
.filter-select:focus { border-color: var(--primary-color); outline: none; }

.filter-actions { display: flex; gap: 10px; margin-top: 8px; }
.btn-filter-apply,
.btn-filter-reset {
    flex: 1;
    padding: 11px 10px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-filter-apply {
    background: var(--primary-color);
    color: var(--primary-color);
}
.btn-filter-apply:hover { background: var(--primary-color); color: var(--primary-color); }
.btn-filter-reset {
    background: var(--bg-color);
    color: var(--text-color);
}
.btn-filter-reset:hover { background: var(--bg-color); }

/* Results Bar */
.listing-results-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--white-color);
    padding: 14px 20px;
    border-radius: 10px;
    margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
#results-count {
    font-size: 14px;
    color: var(--text-color);
    font-weight: 600;
}
.listing-view-toggle { display: flex; gap: 6px; }
.view-btn {
    width: 34px;
    height: 34px;
    border: 1.5px solid var(--divider-color);
    background: var(--white-color);
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    color: var(--text-color);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.view-btn.active, .view-btn:hover {
    background: var(--primary-color);
    color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Grid View */
.properties-grid-view { display: flex; flex-wrap: wrap; margin: 0 -10px; }
.properties-grid-view .prop-col { width: 33.333%; padding: 0 10px; margin-bottom: 20px; }

/* List View */
.properties-list-view { display: flex; flex-direction: column; gap: 18px; }
.properties-list-view .prop-col { width: 100%; }

/* Property Card */
.property-card {
    background: var(--white-color);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}
.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.13);
}
.property-card-image {
    position: relative;
    overflow: hidden;
}
.property-card-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
    display: block;
}
.property-card:hover .property-card-image img { transform: scale(1.06); }
.property-card-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--primary-color);
    color: var(--primary-color);
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
    text-transform: uppercase;
}
.property-card-featured {
    position: absolute;
    top: 12px;
    right: 12px;
    background: var(--primary-color);
    color: var(--primary-color);
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
}
.property-card-body { padding: 16px 18px 18px; }
.property-card-category {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--primary-color);
    margin-bottom: 6px;
}
.property-card h3 {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0 0 10px;
    line-height: 1.4;
}
.property-card h3 a { color: inherit; text-decoration: none; transition: color 0.3s; }
.property-card h3 a:hover { color: var(--primary-color); }
.property-card-location {
    font-size: 13px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 14px;
}
.property-card-location i { color: var(--primary-color); }
.card-spec-tags {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 3;
}
.card-spec-tag {
    background: rgba(13, 96, 121, 0.92);
    padding: 8px 16px 8px 13px;
    border-radius: 30px 0 0 30px;
    border-left: 3px solid #D5AA83;
    min-width: 110px;
    backdrop-filter: blur(6px);
}
.cst-label {
    display: block;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #D5AA83;
    line-height: 1;
    margin-bottom: 4px;
}
.cst-val {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    line-height: 1;
}
.property-card-price {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary-color);
}
.property-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid var(--divider-color);
    margin-top: 12px;
}
.property-card-link {
    font-size: 13px;
    font-weight: 700;
    color: var(--primary-color);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.3s;
}
.property-card-link:hover { color: var(--primary-color); gap: 10px; }
.property-card-process {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 50px;
    text-transform: uppercase;
}
.process-ongoing   { background: var(--bg-color); color: var(--primary-color); }
.process-upcoming  { background: var(--bg-color); color: var(--accent-color); }
.process-completed { background: #e8f5e9; color: #28a745; }

/* List view card variation */
.properties-list-view .property-card {
    display: flex;
    flex-direction: row;
}
.properties-list-view .property-card-image { width: 280px; flex-shrink: 0; }
.properties-list-view .property-card-image img { height: 100%; max-height: 200px; }
.properties-list-view .property-card-body { flex: 1; }

/* Loading state */
.listing-loading {
    width: 100%;
    text-align: center;
    padding: 80px 20px;
    color: var(--text-color);
}
.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--divider-color);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 16px;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* No results */
.no-properties {
    width: 100%;
    text-align: center;
    padding: 80px 20px;
    color: var(--text-color);
}
.no-properties h4 { font-size: 20px; margin-bottom: 10px; color: var(--text-color); }

@media (max-width: 991px) {
    .properties-grid-view .prop-col { width: 50%; }
    .listing-filter-box { position: static; margin-bottom: 30px; }
    .properties-list-view .property-card { flex-direction: column; }
    .properties-list-view .property-card-image { width: 100%; }
}
@media (max-width: 575px) {
    .properties-grid-view .prop-col { width: 100%; }
}
</style>

<script>
(function() {
    var BASE_URL = '<?php echo site_url(); ?>';
    var SEARCH_URL = '<?php echo site_url('listing/search'); ?>';
    var isListView = false;

    // Location filter: show only locations matching selected city
    var citySelect     = document.getElementById('filter-city');
    var locationSelect = document.getElementById('filter-location');
    var allLocOptions  = [];

    // Cache all location options
    Array.from(locationSelect.options).forEach(function(opt) {
        if (opt.value) allLocOptions.push({ value: opt.value, text: opt.text, city: opt.getAttribute('data-city') });
    });

    citySelect.addEventListener('change', function() {
        var selectedCity = this.value.trim();
        // Reset location
        locationSelect.innerHTML = '<option value="">All Locations</option>';
        allLocOptions.forEach(function(loc) {
            if (!selectedCity || loc.city === selectedCity) {
                var opt = document.createElement('option');
                opt.value = loc.value;
                opt.textContent = loc.text;
                opt.setAttribute('data-city', loc.city);
                locationSelect.appendChild(opt);
            }
        });
    });

    // Load properties via AJAX
    function loadProperties() {
        var grid = document.getElementById('properties-grid');
        grid.innerHTML = '<div class="listing-loading"><div class="loading-spinner"></div><p>Loading properties...</p></div>';

        var params = new URLSearchParams();
        var city     = citySelect.value;
        var location = locationSelect.value;
        var category = document.getElementById('filter-category') ? document.getElementById('filter-category').value : '';
        var sort     = document.getElementById('filter-sort').value;

        if (city)     params.set('city', city);
        if (location) params.set('location', location);
        if (category) params.set('category', category);
        if (sort)     params.set('sort_by', sort);

        fetch(SEARCH_URL + '?' + params.toString())
            .then(function(r) { return r.json(); })
            .then(function(data) { renderProperties(data); })
            .catch(function() {
                grid.innerHTML = '<div class="no-properties"><h4>Could not load properties.</h4></div>';
            });
    }

    function renderProperties(data) {
        var grid = document.getElementById('properties-grid');
        var countEl = document.getElementById('results-count');

        if (!data.success || !data.properties || data.properties.length === 0) {
            countEl.textContent = '0 Properties Found';
            grid.innerHTML = '<div class="no-properties"><h4>No properties found.</h4><p>Try adjusting your filters.</p></div>';
            return;
        }

        countEl.textContent = data.properties.length + ' Propert' + (data.properties.length === 1 ? 'y' : 'ies') + ' Found';

        var html = '';
        data.properties.forEach(function(p, i) {
            var propUrl   = BASE_URL + 'property/' + (p.slug || p.id);
            var imgSrc    = p.main_image || (BASE_URL + 'images/project-image-' + ((p.id % 8) || 8) + '.jpg');
            // price hidden per site requirement
            var process   = p.process || 'Upcoming';
            var procClass = 'process-' + process.toLowerCase();
            var featured  = p.is_featured == 1 ? '<span class="property-card-featured">Featured</span>' : '';

            html += '<div class="prop-col">';
            html += '<div class="property-card">';
            html += '  <div class="property-card-image">';
            html += '    <a href="' + propUrl + '"><img src="' + imgSrc + '" alt="' + escHtml(p.title || p.name || '') + '" loading="lazy"></a>';
            if (p.type)    html += '    <span class="property-card-badge">' + escHtml(p.type.replace('_',' ')) + '</span>';
            html += featured;
            html += '  </div>';
            html += '  <div class="property-card-body">';
            if (p.category) html += '    <div class="property-card-category">' + escHtml(p.category) + '</div>';
            html += '    <h3><a href="' + propUrl + '">' + escHtml(p.title || p.name || 'Property') + '</a></h3>';
            if (p.location || p.city) {
                html += '    <div class="property-card-location"><i class="fa-solid fa-location-dot"></i> ' + escHtml((p.location || '') + (p.city ? ', ' + p.city : '')) + '</div>';
            }
            // price not shown
            html += '    <div class="property-card-footer">';
            html += '      <a href="' + propUrl + '" class="property-card-link">View Details <i class="fa-solid fa-arrow-right"></i></a>';
            html += '      <span class="property-card-process ' + procClass + '">' + escHtml(process) + '</span>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
            html += '</div>';
        });

        grid.innerHTML = html;
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // Apply filter
    document.getElementById('btn-apply-filter').addEventListener('click', loadProperties);

    // Reset filter
    document.getElementById('btn-reset-filter').addEventListener('click', function() {
        citySelect.value     = '';
        locationSelect.innerHTML = '<option value="">All Locations</option>';
        allLocOptions.forEach(function(loc) {
            var opt = document.createElement('option');
            opt.value = loc.value;
            opt.textContent = loc.text;
            opt.setAttribute('data-city', loc.city);
            locationSelect.appendChild(opt);
        });
        if (document.getElementById('filter-category')) document.getElementById('filter-category').value = '';
        document.getElementById('filter-sort').value = 'newest';
        loadProperties();
    });

    // Grid / List toggle
    document.getElementById('view-grid').addEventListener('click', function() {
        document.getElementById('properties-grid').className = 'properties-grid-view';
        this.classList.add('active');
        document.getElementById('view-list').classList.remove('active');
        isListView = false;
    });
    document.getElementById('view-list').addEventListener('click', function() {
        document.getElementById('properties-grid').className = 'properties-list-view';
        this.classList.add('active');
        document.getElementById('view-grid').classList.remove('active');
        isListView = true;
    });

    // Initial load on page ready
    document.addEventListener('DOMContentLoaded', loadProperties);
    // Fallback if DOMContentLoaded already fired
    if (document.readyState !== 'loading') loadProperties();
})();
</script>
