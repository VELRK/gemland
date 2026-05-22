<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/testimonials'); ?>" class="btn btn-secondary me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="mb-0"><i class="fas fa-star me-2"></i>Edit Testimonial</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo base_url('admin/testimonial_edit/'.$testimonial->id); ?>" enctype="multipart/form-data">
                <input type="hidden" name="existing_image" value="<?php echo html_escape($testimonial->author_image); ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="<?php echo html_escape($testimonial->name); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                        <input type="text" name="designation" class="form-control" required value="<?php echo html_escape($testimonial->designation); ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Review <span class="text-danger">*</span></label>
                        <textarea name="review" class="form-control" rows="4" required><?php echo html_escape($testimonial->review); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Author Photo</label>
                        <?php if(!empty($testimonial->author_image)): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url($testimonial->author_image); ?>" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:50%;border:2px solid #dee2e6;">
                                <small class="text-muted ms-2">Current photo</small>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="author_image" class="form-control" accept="image/*">
                        <div class="form-text">Leave empty to keep current photo. JPG/PNG/WEBP, max 2MB.</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="<?php echo $testimonial->sort_order; ?>" min="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?php echo $testimonial->status == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $testimonial->status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                        <a href="<?php echo base_url('admin/testimonials'); ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
