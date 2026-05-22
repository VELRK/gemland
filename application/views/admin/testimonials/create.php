<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/testimonials'); ?>" class="btn btn-secondary me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="mb-0"><i class="fas fa-star me-2"></i>Add Testimonial</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo base_url('admin/testimonial_create'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. R. Karthikeyan">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                        <input type="text" name="designation" class="form-control" required placeholder="e.g. Plot Owner">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Review <span class="text-danger">*</span></label>
                        <textarea name="review" class="form-control" rows="4" required placeholder="Client review text..."></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Author Photo</label>
                        <input type="file" name="author_image" class="form-control" accept="image/*">
                        <div class="form-text">JPG/PNG/WEBP, max 2MB</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
                        <a href="<?php echo base_url('admin/testimonials'); ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
