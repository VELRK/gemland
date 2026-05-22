<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-edit me-2"></i>Edit Blog</h2>

    <div class="card">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Blog Name *</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $blog->name; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date *</label>
                        <input type="date" class="form-control" name="date" value="<?php echo $blog->date ? date('Y-m-d', strtotime($blog->date)) : date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" class="form-control" name="author" value="<?php echo $blog->author; ?>" placeholder="Author name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="active" <?php echo $blog->status == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $blog->status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Notes</label>
                    <textarea class="form-control" name="short_notes" rows="3" placeholder="Brief summary/excerpt of the blog"><?php echo $blog->short_notes; ?></textarea>
                    <small class="text-muted">This will be displayed as a preview/summary</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description *</label>
                    <textarea class="form-control" name="description" rows="10" required><?php echo $blog->description; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gallery Images</label>
                    <?php 
                    $existing_gallery = array();
                    if($blog->gallery) {
                        $existing_gallery = json_decode($blog->gallery, true);
                    }
                    ?>
                    <?php if(!empty($existing_gallery)): ?>
                        <div class="mb-3 p-3 border rounded bg-light" id="blogGalleryContainer">
                            <h6 class="mb-3">Current Gallery Images (<span id="blogGalleryCount"><?php echo count($existing_gallery); ?></span> images):</h6>
                            <div class="d-flex flex-wrap gap-3" id="blogExistingGalleryContainer">
                                <?php foreach($existing_gallery as $index => $img): ?>
                                    <div class="position-relative blog-gallery-item" data-image="<?php echo htmlspecialchars($img); ?>" style="width: 150px; height: 150px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <img src="<?php echo base_url($img); ?>" class="w-100 h-100" style="object-fit: cover; display: block;">
                                        <input type="hidden" name="existing_gallery[]" value="<?php echo htmlspecialchars($img); ?>" class="blog-gallery-input">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute remove-blog-gallery-image" style="top: 5px; right: 5px; padding: 0; line-height: 1; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 2px 6px rgba(0,0,0,0.4); border: 2px solid #fff; background: #dc3545; cursor: pointer;" title="Remove image">
                                            <i class="fas fa-times" style="font-size: 14px; color: #fff;"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted d-block mt-3">
                                <i class="fas fa-info-circle me-1"></i>
                                Click the <strong>X</strong> button to remove images. Uploading new images will add to existing gallery.
                            </small>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="gallery[]" multiple accept="image/*" id="galleryInput">
                    <small class="text-muted">Select new images to add to gallery (Hold Ctrl/Cmd to select multiple)</small>
                    <div id="galleryPreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>
                <script>
                    // Remove blog gallery image functionality
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.remove-blog-gallery-image')) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            const galleryItem = e.target.closest('.blog-gallery-item');
                            if (galleryItem) {
                                // Remove the hidden input
                                const hiddenInput = galleryItem.querySelector('.blog-gallery-input');
                                if (hiddenInput) {
                                    hiddenInput.remove();
                                }
                                
                                // Add fade out effect
                                galleryItem.style.transition = 'opacity 0.3s, transform 0.3s';
                                galleryItem.style.opacity = '0';
                                galleryItem.style.transform = 'scale(0.8)';
                                
                                setTimeout(function() {
                                    // Remove the image container
                                    galleryItem.remove();
                                    
                                    // Update gallery count
                                    updateBlogGalleryCount();
                                }, 300);
                            }
                        }
                    });

                    // Function to update blog gallery count
                    function updateBlogGalleryCount() {
                        const container = document.getElementById('blogExistingGalleryContainer');
                        const countElement = document.getElementById('blogGalleryCount');
                        const galleryContainer = document.getElementById('blogGalleryContainer');
                        
                        if (container && countElement) {
                            const remainingImages = container.querySelectorAll('.blog-gallery-item').length;
                            countElement.textContent = remainingImages;
                            
                            // Show/hide container based on image count
                            if (galleryContainer) {
                                if (remainingImages === 0) {
                                    galleryContainer.style.display = 'none';
                                } else {
                                    galleryContainer.style.display = 'block';
                                }
                            }
                        }
                    }

                    // Preview new gallery images
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
                                            <span class="badge bg-success position-absolute top-0 end-0">New</span>
                                        `;
                                        preview.appendChild(div);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        }
                    });
                </script>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Blog
                    </button>
                    <a href="<?php echo base_url('admin/blogs'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

