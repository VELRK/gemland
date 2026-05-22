<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$_featured_url    = get_blog_image($blog);          // first gallery image or fallback
$_gallery_urls    = get_blog_gallery($blog);         // all gallery images (verified)
$_blog_url        = get_blog_url($blog);
?>

<!-- Page Header Section Start -->
<div class="page-header bg-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque"><?php echo html_escape($blog->name); ?></h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('blog'); ?>">Blog</a></li>
                            <li class="breadcrumb-item active"><?php echo html_escape($blog->name); ?></li>
                        </ol>
                    </nav>
                    <div class="post-header-meta wow fadeInUp" data-wow-delay="0.2s">
                        <?php if (!empty($blog->date)): ?>
                        <span class="post-meta-item"><i class="fa-regular fa-calendar"></i> <?php echo date('F j, Y', strtotime($blog->date)); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($blog->author)): ?>
                        <span class="post-meta-item"><i class="fa-regular fa-user"></i> <?php echo html_escape($blog->author); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header Section End -->

<!-- Blog Single Section Start -->
<div class="page-blog-single">
    <div class="container">
        <div class="row">

            <!-- Blog Content Column Start -->
            <div class="col-lg-8">
                <div class="blog-post wow fadeInUp">

                    <!-- Post Featured Image Start -->
                    <div class="post-featured-image">
                        <figure class="image-anime">
                            <img src="<?php echo $_featured_url; ?>" alt="<?php echo html_escape($blog->name); ?>">
                        </figure>
                    </div>
                    <!-- Post Featured Image End -->

                    <!-- Post Content Body Start -->
                    <div class="post-content-body">

                        <?php if (!empty($blog->short_notes)): ?>
                        <!-- Short Notes as Blockquote -->
                        <blockquote class="post-blockquote wow fadeInUp">
                            <p><?php echo nl2br(html_escape($blog->short_notes)); ?></p>
                        </blockquote>
                        <?php endif; ?>

                        <?php if (!empty($blog->description)): ?>
                        <div class="post-content-text">
                            <?php echo $blog->description; ?>
                        </div>
                        <?php endif; ?>

                        <?php if (count($_gallery_urls) > 1): ?>
                        <!-- Additional Gallery Images Start -->
                        <div class="post-gallery-grid">
                            <div class="row">
                                <?php foreach (array_slice($_gallery_urls, 1) as $gurl): ?>
                                <div class="col-md-6">
                                    <figure class="image-anime">
                                        <img src="<?php echo $gurl; ?>" alt="">
                                    </figure>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Additional Gallery Images End -->
                        <?php endif; ?>

                        <!-- Post Footer Info Start -->
                        <div class="post-footer-info wow fadeInUp">
                            <?php if (!empty($blog->author)): ?>
                            <div class="post-author-label">
                                <i class="fa-regular fa-user"></i>
                                <span>By <?php echo html_escape($blog->author); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="post-share-box">
                                <span>Share:</span>
                                <ul class="post-share-links">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" target="_blank" rel="noopener">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://wa.me/?text=<?php echo urlencode($blog->name . ' ' . current_url()); ?>" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>&title=<?php echo urlencode($blog->name); ?>" target="_blank" rel="noopener">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Post Footer Info End -->

                    </div>
                    <!-- Post Content Body End -->

                </div>
                <!-- Blog Post End -->

                <!-- Back to Blog Link -->
                <div class="post-back-link wow fadeInUp" data-wow-delay="0.2s">
                    <a href="<?php echo site_url('blog'); ?>" class="btn-default">
                        <i class="fa-solid fa-arrow-left"></i> Back to Blog
                    </a>
                </div>

            </div>
            <!-- Blog Content Column End -->

            <!-- Sidebar Column Start -->
            <div class="col-lg-4">
                <div class="blog-sidebar">

                    <?php if (!empty($recent_blogs)): ?>
                    <!-- Recent Posts Widget Start -->
                    <div class="sidebar-widget wow fadeInUp">
                        <div class="sidebar-widget-title">
                            <h3>Recent Posts</h3>
                        </div>
                        <ul class="recent-post-list">
                            <?php foreach ($recent_blogs as $idx => $rb): ?>
                            <?php
                            $rb_img  = get_blog_image($rb);
                            $rb_link = get_blog_url($rb);
                            ?>
                            <li class="recent-post-item wow fadeInUp" data-wow-delay="<?php echo $idx * 0.1; ?>s">
                                <div class="recent-post-thumb">
                                    <a href="<?php echo $rb_link; ?>">
                                        <figure class="image-anime">
                                            <img src="<?php echo $rb_img; ?>" alt="<?php echo html_escape($rb->name); ?>">
                                        </figure>
                                    </a>
                                </div>
                                <div class="recent-post-content">
                                    <?php if (!empty($rb->date)): ?>
                                    <span class="recent-post-date"><i class="fa-regular fa-calendar"></i> <?php echo date('M j, Y', strtotime($rb->date)); ?></span>
                                    <?php endif; ?>
                                    <h4><a href="<?php echo $rb_link; ?>"><?php echo html_escape($rb->name); ?></a></h4>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- Recent Posts Widget End -->
                    <?php endif; ?>

                </div>
            </div>
            <!-- Sidebar Column End -->

        </div>
    </div>
</div>
<!-- Blog Single Section End -->

<style>
/* Blog Single Page */
.page-blog-single {
    padding: 80px 0;
}

/* Post Meta in Header */
.post-header-meta {
    display: flex;
    gap: 24px;
    margin-top: 16px;
    flex-wrap: wrap;
}
.post-header-meta .post-meta-item {
    color: var(--white-color);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.post-header-meta .post-meta-item i {
    color: var(--primary-color);
}

/* Blog Post Card */
.blog-post {
    background: var(--white-color);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 30px rgba(0,0,0,0.07);
}
.blog-post .post-featured-image img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    display: block;
}

/* Post Content Body */
.post-content-body {
    padding: 40px;
}

/* Blockquote */
.post-blockquote {
    position: relative;
    background: var(--bg-color);
    border-left: 4px solid var(--primary-color);
    padding: 28px 32px 28px 64px;
    margin: 32px 0;
    border-radius: 0 8px 8px 0;
}
.post-blockquote::before {
    content: '\201C';
    position: absolute;
    left: 20px;
    top: 16px;
    font-size: 60px;
    line-height: 1;
    color: var(--primary-color);
    font-family: Georgia, serif;
}
.post-blockquote p {
    font-size: 16px;
    font-weight: 600;
    line-height: 1.7;
    margin: 0;
    color: var(--primary-color);
}

/* Content Text */
.post-content-text {
    font-size: 15px;
    line-height: 1.8;
    color: var(--text-color);
    margin: 24px 0;
}
.post-content-text p      { margin-bottom: 16px; }
.post-content-text h2,
.post-content-text h3,
.post-content-text h4     { color: var(--primary-color); margin: 28px 0 14px; }
.post-content-text ul,
.post-content-text ol     { padding-left: 20px; margin-bottom: 16px; }
.post-content-text li     { margin-bottom: 8px; color: var(--text-color); }

/* Gallery Grid */
.post-gallery-grid { margin: 28px 0; }
.post-gallery-grid .image-anime {
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 16px;
}
.post-gallery-grid img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

/* Post Footer */
.post-footer-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    padding-top: 24px;
    border-top: 1px solid var(--divider-color);
    margin-top: 32px;
}
.post-author-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-color);
    font-size: 14px;
}
.post-author-label i { color: var(--primary-color); }

/* Share */
.post-share-box {
    display: flex;
    align-items: center;
    gap: 12px;
}
.post-share-box > span {
    font-size: 14px;
    color: var(--text-color);
    font-weight: 600;
}
.post-share-links {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 8px;
}
.post-share-links li a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--primary-color);
    color: var(--white-color);
    font-size: 14px;
    transition: background 0.3s ease, color 0.3s ease;
}
.post-share-links li a:hover {
    background: var(--primary-color);
    color: var(--primary-color);
}

/* Back link */
.post-back-link { margin-top: 32px; }
.post-back-link .btn-default {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Sidebar */
.blog-sidebar { padding-left: 20px; }
.sidebar-widget {
    background: var(--white-color);
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 4px 30px rgba(0,0,0,0.07);
    margin-bottom: 32px;
}
.sidebar-widget-title h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0 0 24px;
    padding-bottom: 14px;
    border-bottom: 2px solid var(--primary-color);
}

/* Recent Posts */
.recent-post-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.recent-post-item {
    display: flex;
    gap: 14px;
    padding-bottom: 18px;
    margin-bottom: 18px;
    border-bottom: 1px solid var(--divider-color);
}
.recent-post-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.recent-post-thumb {
    flex-shrink: 0;
    width: 80px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
}
.recent-post-thumb .image-anime { width: 100%; height: 100%; }
.recent-post-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.recent-post-content { flex: 1; min-width: 0; }
.recent-post-date {
    font-size: 12px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 6px;
}
.recent-post-date i { color: var(--primary-color); }
.recent-post-content h4 {
    font-size: 14px;
    line-height: 1.5;
    margin: 0;
    font-weight: 600;
}
.recent-post-content h4 a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.recent-post-content h4 a:hover { color: var(--primary-color); }

@media (max-width: 991px) {
    .blog-sidebar { padding-left: 0; margin-top: 40px; }
    .blog-post .post-featured-image img { height: 280px; }
    .post-content-body { padding: 24px; }
}
</style>
