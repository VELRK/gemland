<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-plus me-2"></i>Create Property</h2>

    <div class="card">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category *</label>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category->category_name); ?>">
                                    <?php echo htmlspecialchars($category->category_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">
                            <a href="<?php echo base_url('admin/categories'); ?>" target="_blank">Manage Categories</a>
                        </small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City *</label>
                        <select class="form-control" name="city" id="citySelect" required>
                            <option value="">Select City</option>
                            <?php foreach($cities as $city): ?>
                                <option value="<?php echo $city->name; ?>"><?php echo $city->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">
                            <a href="<?php echo base_url('admin/cities'); ?>" target="_blank">Manage Cities</a>
                        </small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location *</label>
                        <select class="form-control" name="location" id="locationSelect" required>
                            <option value="">Select Location</option>
                            <?php foreach($all_locations as $location): ?>
                                <option value="<?php echo $location->name; ?>" data-city-name="<?php echo htmlspecialchars($location->city_name); ?>">
                                    <?php echo $location->name; ?> (<?php echo $location->city_name; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">
                            <a href="<?php echo base_url('admin/locations'); ?>" target="_blank">Manage Locations</a>
                        </small>
                    </div>
                </div>
                <script>
                    // Filter locations based on selected city
                    document.getElementById('citySelect').addEventListener('change', function() {
                        const selectedCity = this.value;
                        const locationSelect = document.getElementById('locationSelect');
                        const options = locationSelect.querySelectorAll('option');
                        
                        // Show all options first
                        options.forEach(option => {
                            if (option.value !== '') {
                                option.style.display = 'block';
                            }
                        });
                        
                        // Hide options that don't match selected city
                        if (selectedCity) {
                            options.forEach(option => {
                                if (option.value !== '' && option.dataset.cityName) {
                                    if (option.dataset.cityName !== selectedCity) {
                                        option.style.display = 'none';
                                    }
                                }
                            });
                        }
                        
                        // Reset location selection
                        locationSelect.value = '';
                    });
                </script>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price *</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>                    
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Plot</label>
                        <input type="text" class="form-control" name="total_plot" placeholder="e.g. 10 Acres, 5000 sq ft">
                        <small class="text-muted">Total area of the project/plot</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Available Size</label>
                        <input type="text" class="form-control" name="available_size" placeholder="e.g. 200–500 sq ft, 30×40">
                        <small class="text-muted">Unit/plot size available for purchase</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Video URL</label>
                    <input type="url" class="form-control" name="video" placeholder="https://youtube.com/...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Image *</label>
                    <input type="file" class="form-control" name="main_image" accept="image/*" id="mainImageInput" required>
                    <small class="text-muted">This will be the featured/main image for the property</small>
                    <div id="mainImagePreview" class="mt-2"></div>
                </div>
                <script>
                    document.getElementById('mainImageInput').addEventListener('change', function(e) {
                        const preview = document.getElementById('mainImagePreview');
                        preview.innerHTML = '';
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'img-thumbnail';
                                img.style.maxWidth = '300px';
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                </script>

                <div class="mb-3">
                    <label class="form-label">Gallery Images</label>
                    <input type="file" class="form-control" name="gallery[]" multiple accept="image/*" id="galleryInput">
                    <small class="text-muted">You can select multiple images (Hold Ctrl/Cmd to select multiple)</small>
                    <div id="galleryPreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>
                <script>
                    document.getElementById('galleryInput').addEventListener('change', function(e) {
                        const preview = document.getElementById('galleryPreview');
                        preview.innerHTML = '';
                        if (this.files) {
                            Array.from(this.files).forEach(file => {
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const div = document.createElement('div');
                                        div.className = 'position-relative';
                                        div.innerHTML = `
                                            <img src="${e.target.result}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                        `;
                                        preview.appendChild(div);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        }
                    });
                </script>

                <div class="mb-3">
                    <label class="form-label">Location URL <small class="text-muted">(Google Maps)</small></label>
                    <input type="text" class="form-control" name="location_url" placeholder="Paste Google Maps link here (any format)">
                    <small class="text-muted">
                        Open Google Maps, search the location, then copy the URL from your browser and paste here.
                        The map will automatically appear on the property page.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor Plan Image</label>
                    <input type="file" class="form-control" name="floorplan" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nearby Places <small class="text-muted">(Optional)</small></label>
                    <div id="nearbyPlacesContainer">
                        <!-- Empty container - user can add places if needed -->
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="addNearbyPlace">
                        <i class="fas fa-plus me-1"></i>Add Nearby Place
                    </button>
                    <small class="text-muted d-block mt-2">Example: School 2km, Hospital 1.5km (Optional field)</small>
                </div>
                <script>
                    document.getElementById('addNearbyPlace').addEventListener('click', function() {
                        const container = document.getElementById('nearbyPlacesContainer');
                        const newItem = document.createElement('div');
                        newItem.className = 'nearby-place-item mb-2 row';
                        newItem.innerHTML = `
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nearby_title[]" placeholder="Place name (e.g., School)">
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.1" class="form-control" name="nearby_distance[]" placeholder="Distance in km" min="0">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-nearby">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                        container.appendChild(newItem);
                    });
                    
                    // Remove nearby place
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.remove-nearby')) {
                            const item = e.target.closest('.nearby-place-item');
                            item.remove();
                        }
                    });
                </script>

                <?php
                $logos_dir = FCPATH . 'assets/logos/';
                $logo_files = array();
                if (is_dir($logos_dir)) {
                    foreach (scandir($logos_dir) as $file) {
                        if (is_file($logos_dir . $file) && preg_match('/\.(png|jpg|jpeg|gif|webp|svg)$/i', $file)) {
                            $logo_files[] = $file;
                        }
                    }
                    sort($logo_files);
                }
                ?>
                <div class="mb-3">
                    <label class="form-label">Features / Amenities <small class="text-muted">(Optional)</small></label>
                    <div id="featuresContainer"></div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="addFeature">
                        <i class="fas fa-plus me-1"></i>Add Feature
                    </button>
                    <small class="text-muted d-block mt-2">Enter the feature name and optionally pick an icon from the logos folder.</small>
                </div>

                <!-- Logo Picker Modal -->
                <div class="modal fade" id="logoPickerModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-image me-2"></i>Select Feature Icon</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($logo_files)): ?>
                                <div class="row g-3">
                                    <?php foreach ($logo_files as $logo): ?>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <div class="logo-option text-center p-3 border rounded" data-logo="<?php echo htmlspecialchars($logo); ?>" style="cursor:pointer;transition:all 0.2s;">
                                            <img src="<?php echo base_url('assets/logos/' . rawurlencode($logo)); ?>" style="width:60px;height:60px;object-fit:contain;" alt="<?php echo htmlspecialchars(pathinfo($logo, PATHINFO_FILENAME)); ?>">
                                            <small class="d-block mt-2 text-muted"><?php echo htmlspecialchars(pathinfo($logo, PATHINFO_FILENAME)); ?></small>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <p class="text-muted">No logo files found in assets/logos/</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                (function() {
                    var baseUrl = '<?php echo base_url(); ?>';
                    var activeFeatureRow = null;

                    function createFeatureRow(name, icon) {
                        var row = document.createElement('div');
                        row.className = 'feature-item mb-2 d-flex align-items-center gap-2 flex-wrap';
                        var imgSrc = icon ? baseUrl + 'assets/logos/' + encodeURIComponent(icon) : '';
                        var s = 'width:48px;height:48px;object-fit:contain;border:1px solid #dee2e6;border-radius:6px;background:#f8f9fa;padding:4px;flex-shrink:0;';
                        row.innerHTML = '<img src="' + imgSrc + '" class="feature-icon-preview" style="' + s + '" alt="">'
                            + '<input type="hidden" name="feature_icon[]" value="' + (icon || '') + '">'
                            + '<input type="text" class="form-control" name="feature_name[]" value="' + (name || '') + '" placeholder="Feature name (e.g., Garden, Swimming Pool)" style="max-width:260px;">'
                            + '<button type="button" class="btn btn-outline-secondary btn-sm pick-logo-btn"><i class="fas fa-image me-1"></i>Pick Icon</button>'
                            + '<button type="button" class="btn btn-danger btn-sm remove-feature"><i class="fas fa-times"></i></button>';
                        return row;
                    }

                    document.getElementById('addFeature').addEventListener('click', function() {
                        document.getElementById('featuresContainer').appendChild(createFeatureRow('', ''));
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.pick-logo-btn')) {
                            activeFeatureRow = e.target.closest('.feature-item');
                            new bootstrap.Modal(document.getElementById('logoPickerModal')).show();
                        }
                        if (e.target.closest('.logo-option')) {
                            var option = e.target.closest('.logo-option');
                            var logo = option.dataset.logo;
                            if (activeFeatureRow) {
                                activeFeatureRow.querySelector('input[name="feature_icon[]"]').value = logo;
                                activeFeatureRow.querySelector('.feature-icon-preview').src = baseUrl + 'assets/logos/' + encodeURIComponent(logo);
                            }
                            bootstrap.Modal.getInstance(document.getElementById('logoPickerModal')).hide();
                            document.querySelectorAll('.logo-option').forEach(function(el) { el.style.background = ''; el.style.borderColor = ''; });
                            option.style.background = '#e8f4fd';
                            option.style.borderColor = '#0d6efd';
                        }
                        if (e.target.closest('.remove-feature')) {
                            e.target.closest('.feature-item').remove();
                        }
                    });
                })();
                </script>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_latest" value="1" id="isLatest">
                            <label class="form-check-label" for="isLatest">
                                <strong>Latest Property</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured">
                            <label class="form-check-label" for="isFeatured">
                                <strong>Featured Property</strong>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Property
                    </button>
                    <a href="<?php echo base_url('admin/properties'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

