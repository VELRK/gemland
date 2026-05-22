<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-map-marker-alt me-2"></i>Locations</h2>
        <a href="<?php echo base_url('admin/location_create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Location
        </a>
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Location Name</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($locations)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No locations found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($locations as $location): ?>
                                <tr>
                                    <td><?php echo $location->id; ?></td>
                                    <td>
                                        <?php if(!empty($location->image)): ?>
                                            <img src="<?php echo base_url($location->image); ?>" alt="<?php echo htmlspecialchars($location->name); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <span class="text-muted">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $location->name; ?></td>
                                    <td><?php echo $location->city_name; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $location->status == 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($location->status); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($location->created_at)); ?></td>
                                    <td>
                                        <a href="<?php echo base_url('admin/location_edit/'.$location->id); ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/location_delete/'.$location->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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

