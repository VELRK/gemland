<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/seo'); ?>" class="btn btn-secondary me-3"><i class="fas fa-arrow-left"></i></a>
        <h2 class="mb-0"><i class="fas fa-search me-2"></i>SEO — <?php echo html_escape($seo->page_label); ?></h2>
    </div>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo base_url('admin/seo_edit/'.$seo->id); ?>">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Meta Title <small class="text-muted fw-normal">(recommended: 50–60 characters)</small></label>
                    <input type="text" name="title" class="form-control" maxlength="255"
                           value="<?php echo html_escape($seo->title); ?>"
                           placeholder="e.g. Gem Housing – Premium Real Estate in Coimbatore">
                    <div class="form-text"><span id="title-count">0</span> / 255 characters</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Meta Keywords <small class="text-muted fw-normal">(comma-separated)</small></label>
                    <input type="text" name="keywords" class="form-control" maxlength="500"
                           value="<?php echo html_escape($seo->keywords); ?>"
                           placeholder="e.g. real estate, flats in coimbatore, residential projects">
                    <div class="form-text"><span id="kw-count">0</span> / 500 characters</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Meta Description <small class="text-muted fw-normal">(recommended: 150–160 characters)</small></label>
                    <textarea name="description" class="form-control" rows="3" maxlength="500"
                              placeholder="e.g. Gem Housing delivers premium residential and commercial projects in Coimbatore with trust and quality."><?php echo html_escape($seo->description); ?></textarea>
                    <div class="form-text"><span id="desc-count">0</span> / 500 characters</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save SEO</button>
                    <a href="<?php echo base_url('admin/seo'); ?>" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function() {
    function counter(inputId, countId) {
        var el = document.querySelector('[name="' + inputId + '"]');
        var ct = document.getElementById(countId);
        if (!el || !ct) return;
        function update() { ct.textContent = el.value.length; }
        update();
        el.addEventListener('input', update);
    }
    counter('title', 'title-count');
    counter('keywords', 'kw-count');
    counter('description', 'desc-count');
})();
</script>
