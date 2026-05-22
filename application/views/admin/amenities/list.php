<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-star-of-life me-2"></i>Amenities</h2>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Amenity Logo</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('admin/amenity_upload'); ?>" method="post" enctype="multipart/form-data">
                <div class="row align-items-end g-3">
                    <div class="col-md-7">
                        <label class="form-label">Select Image (JPG, PNG, GIF, WEBP &mdash; max 2 MB)</label>
                        <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-1"></i> Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-images me-2"></i>Amenity Logos (<?php echo count($logos); ?>)</h5>
        </div>
        <div class="card-body">
            <?php if (empty($logos)): ?>
                <p class="text-muted text-center py-4">No logos found. Upload your first amenity logo above.</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($logos as $logo): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card text-center h-100 shadow-sm">
                            <div class="card-body p-3">
                                <img src="<?php echo base_url($logo['path']); ?>"
                                     alt="<?php echo html_escape($logo['name']); ?>"
                                     style="width:72px;height:72px;object-fit:contain;">
                                <p class="small mt-2 mb-2 text-truncate fw-semibold"
                                   title="<?php echo html_escape($logo['name']); ?>">
                                    <?php echo html_escape($logo['name']); ?>
                                </p>
                                <form action="<?php echo base_url('admin/amenity_delete'); ?>" method="post"
                                      onsubmit="return confirm('Delete <?php echo html_escape(addslashes($logo['name'])); ?>?')">
                                    <input type="hidden" name="filename" value="<?php echo html_escape($logo['name']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
