<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-star me-2"></i>Testimonials</h2>
        <a href="<?php echo base_url('admin/testimonial_create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Testimonial
        </a>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Order</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($testimonials)): ?>
                            <tr><td colspan="7" class="text-center">No testimonials found</td></tr>
                        <?php else: ?>
                            <?php foreach($testimonials as $t): ?>
                            <tr>
                                <td><?php echo $t->sort_order; ?></td>
                                <td>
                                    <?php if(!empty($t->author_image)): ?>
                                        <img src="<?php echo base_url($t->author_image); ?>" alt="" style="width:45px;height:45px;object-fit:cover;border-radius:50%;">
                                    <?php else: ?>
                                        <div style="width:45px;height:45px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user text-muted"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo html_escape($t->name); ?></strong></td>
                                <td><?php echo html_escape($t->designation); ?></td>
                                <td class="text-truncate" style="max-width:280px;"><?php echo html_escape($t->review); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $t->status == 'active' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($t->status); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('admin/testimonial_edit/'.$t->id); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/testimonial_delete/'.$t->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this testimonial?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
