<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-search me-2"></i>SEO Settings</h2>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-3">Set the meta title, keywords, and description for each page. These are used by search engines to index your site.</p>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Page</th>
                            <th>Meta Title</th>
                            <th>Keywords</th>
                            <th>Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pages as $page): ?>
                        <tr>
                            <td><strong><?php echo html_escape($page->page_label); ?></strong><br><small class="text-muted"><?php echo html_escape($page->page_key); ?></small></td>
                            <td><?php echo $page->title ? html_escape($page->title) : '<span class="text-muted">—</span>'; ?></td>
                            <td class="text-truncate" style="max-width:200px;"><?php echo $page->keywords ? html_escape($page->keywords) : '<span class="text-muted">—</span>'; ?></td>
                            <td class="text-truncate" style="max-width:250px;"><?php echo $page->description ? html_escape($page->description) : '<span class="text-muted">—</span>'; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url('admin/seo_edit/'.$page->id); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
