<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header Section Start -->
<div class="page-header bg-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">Our <span>blog</span></h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('blog'); ?>">Blog</a></li>
                        </ol>
                    </nav>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header Section End -->

<!-- Page Blog Start -->
<div class="page-blog">
    <div class="container">
        <div class="row">
            <?php if (!empty($blogs)): ?>

                <?php $delay = 0; foreach ($blogs as $blog): ?>
                <?php
                $img_url  = get_blog_image($blog);
                $blog_url = get_blog_url($blog);
                ?>

                <div class="col-xl-4 col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" <?php echo $delay > 0 ? 'data-wow-delay="' . $delay . 's"' : ''; ?>>

                        <!-- Post Featured Image Start -->
                        <div class="post-featured-image">
                            <a href="<?php echo $blog_url; ?>" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="<?php echo $img_url; ?>" alt="<?php echo html_escape($blog->name); ?>">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <?php if (!empty($blog->date) || !empty($blog->author)): ?>
                            <div class="post-item-meta">
                                <?php if (!empty($blog->date)): ?>
                                <span><i class="fa-regular fa-calendar"></i> <?php echo date('M j, Y', strtotime($blog->date)); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($blog->author)): ?>
                                <span><i class="fa-regular fa-user"></i> <?php echo html_escape($blog->author); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="<?php echo $blog_url; ?>"><?php echo html_escape($blog->name); ?></a></h2>
                                <?php if (!empty($blog->short_notes)): ?>
                                <p><?php
                                    $excerpt = strip_tags($blog->short_notes);
                                    echo html_escape(mb_strlen($excerpt) > 110 ? mb_substr($excerpt, 0, 110) . '...' : $excerpt);
                                ?></p>
                                <?php endif; ?>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start -->
                            <div class="post-item-btn">
                                <a href="<?php echo $blog_url; ?>" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End -->
                        </div>
                        <!-- Post Item Body End -->

                    </div>
                    <!-- Post Item End -->
                </div>

                <?php $delay = round($delay + 0.2, 1); endforeach; ?>

            <?php else: ?>
                <div class="col-lg-12">
                    <div class="text-center" style="padding:80px 0;">
                        <h3 style="color: var(--text-color);">No blog posts found.</h3>
                        <p style="color:var(--text-color);">Check back soon for new articles.</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- Page Blog End -->

<style>
.post-item-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 10px;
}
.post-item-meta span {
    font-size: 13px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 5px;
}
.post-item-meta span i {
    color: var(--primary-color);
}
.post-item-content p {
    font-size: 14px;
    color: var(--text-color);
    line-height: 1.6;
    margin-top: 8px;
}
</style>
