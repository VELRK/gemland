<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header Start -->
<div class="page-header bg-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <!-- Page Header Content Start -->
                    <div class="page-header-content">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Testimonials</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Content End -->
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Testimonials Section Start -->
<div class="our-testimonials bg-section">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title text-center">
                    <span class="section-sub-title wow fadeInUp">Client Testimonials</span>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">What Our Clients Say About Us</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">Hear from our satisfied clients who have experienced our quality construction and real estate services.</p>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Testimonials Grid Start -->
                <div class="testimonials-grid">
                    <?php if (!empty($testimonials)): ?>
                        <?php $delays = ['0', '0.2s', '0.4s', '0.6s']; ?>
                        <?php foreach ($testimonials as $i => $t): ?>
                        <div class="testimonial-item wow fadeInUp" <?php if ($i % 4 > 0) echo 'data-wow-delay="' . $delays[$i % 4] . '"'; ?>>
                            <div class="testimonial-item-header">
                                <div class="testimonial-item-rating">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <div class="testimonial-item-quote"><i class="fa-solid fa-quote-right"></i></div>
                            </div>
                            <div class="testimonial-item-body">
                                <div class="testimonial-item-content">
                                    <p>"<?php echo html_escape($t->review); ?>"</p>
                                </div>
                                <div class="testimonial-item-author">
                                    <div class="testimonial-author-image">
                                        <figure><img src="<?php echo !empty($t->author_image) ? html_escape($t->author_image) : 'images/author-1.jpg'; ?>" alt="<?php echo html_escape($t->name); ?>"></figure>
                                    </div>
                                    <div class="testimonial-author-content">
                                        <h3><?php echo html_escape($t->name); ?></h3>
                                        <p><?php echo html_escape($t->designation); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-4">No testimonials found.</p>
                    <?php endif; ?>
                </div>
                <!-- Testimonials Grid End -->
            </div>
        </div>
    </div>
</div>
<!-- Testimonials Section End -->