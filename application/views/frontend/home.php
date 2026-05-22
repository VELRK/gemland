<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!-- Hero Section Start -->
    <div class="hero hero-video bg-section dark-section">
        <!-- Video Start -->
        <div class="hero-bg-video">
            <!-- Selfhosted Video Start -->
            <!-- <video autoplay muted loop id="myvideo"><source src="images/hero-bg-video.mp4" type="video/mp4"></video> -->
            <video autoplay muted loop id="myvideo"><source src="<?php echo base_url(); ?>property.mp4" type="video/mp4"></video>
            
            <!-- Selfhosted Video End -->

            <!-- Youtube Video Start -->
            <!-- <div id="herovideo" class="player" data-property="{videoURL:'OjTRVpgtcG4',containment:'.hero-video', showControls:false, autoPlay:true, loop:true, vol:0, mute:false, startAt:0,  stopAt:296, opacity:1, addRaster:true, quality:'large', optimizeDisplay:true}"></div> -->
            <!-- Youtube Video End -->
        </div>
        <!-- Video End -->

        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-6">
                    <!-- Hero Content Box Start -->
                    <div class="hero-content-box">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Building Excellence. Delivering Trust.</span>
                            <h1 class="text-anime-style-2" data-cursor="-opaque">Smart Real Estate. <span>Stronger Foundations.</span></h1>
                        </div>
                        <!-- Section Title End -->
                    </div>
                    <!-- Hero Content Box End -->
                </div>

                <div class="col-xl-6">
                    <!-- Hero Counter Box Start -->
                    <div class="hero-counter-box">
                        <!-- Hero Counter List Start -->
                        <div class="hero-counter-list wow fadeInUp">
                            <!-- Hero Counter Item Start -->
                            <div class="hero-counter-item">
                                <h2><span class="counter">15</span>+</h2>
                                <p>Years of Experience</p>
                            </div>
                            <!-- Hero Counter Item End -->

                            <!-- Hero Counter Item Start -->
                            <div class="hero-counter-item">
                                <h2><span class="counter">10</span>+</h2>
                                <p>Project Completed</p>
                            </div>
                            <!-- Hero Counter Item End -->
                        </div>
                        <!-- Hero Counter List End -->

                        <!-- Hero Counter Footer Start -->
                        <div class="hero-counter-footer wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Hero Social Buttons Start -->
                            <div class="hero-social-btns">
                                <a href="https://wa.me/918110065555" target="_blank" rel="noopener" class="hero-social-btn hsb-whatsapp" aria-label="WhatsApp">
                                    <span class="hsb-icon"><i class="fa-brands fa-whatsapp"></i></span>
                                    <span class="hsb-label">WhatsApp</span>
                                </a>
                                <a href="https://www.facebook.com/gemhousing/" target="_blank" rel="noopener" class="hero-social-btn hsb-facebook" aria-label="Facebook">
                                    <span class="hsb-icon"><i class="fa-brands fa-facebook-f"></i></span>
                                    <span class="hsb-label">Facebook</span>
                                </a>
                                <a href="https://www.instagram.com/gem_housing/" target="_blank" rel="noopener" class="hero-social-btn hsb-instagram" aria-label="Instagram">
                                    <span class="hsb-icon"><i class="fa-brands fa-instagram"></i></span>
                                    <span class="hsb-label">Instagram</span>
                                </a>
                            </div>
                            <!-- Hero Social Buttons End -->

                            <!-- Hero Rating Box Start -->
                            <div class="hero-rating-box">
                                <!-- Hero Rating Box Header Start -->
                                <div class="hero-rating-box-header">
                                    <h3><span class="counter">4.9</span></h3>
                                    <p>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                    </p>
                                </div>
                                <!-- Hero Rating Box Header End -->

                                <!-- Hero Rating Box Content Start -->
                                <div class="hero-rating-box-content">
                                    <p>Our Word Wide Customer Review</p>
                                </div>
                                <!-- Hero Rating Box Content End -->
                            </div>
                            <!-- Hero Rating Box End -->
                        </div>
                        <!-- Hero Counter Footer End -->
                    </div>
                    <!-- Hero Counter Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- About US Section Start -->
    <div class="about-us">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-xl-7">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">About Our Services</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Creating Modern Spaces with <span>Trusted Real Estate Expertise</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-xl-5">
                    <!-- Section Content Button Start -->
                    <div class="section-content-btn">
                        <!-- Section Title Content Start -->
                        <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                            <p>We are committed to offering high-quality residential properties with transparency, clarity, and long-term value. Every property is carefully selected to ensure the right location, proper documentation, and customer trust.</p>
                        </div>
                        <!-- Section Title Content End -->
    
                        <!-- Section Button Start -->
                        <div class="section-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="<?php echo site_url('about'); ?>" class="btn-default">Learn More About</a>
                        </div>
                        <!-- Section Button End -->
                    </div>   
                    <!-- Section Content Button End -->
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <!-- About US Image Box Start -->
                    <div class="about-us-image-box wow fadeInUp">
                        <!-- About Us Image Start -->
                        <div class="about-us-image">
                            <figure class="image-anime">
                                <img src="images/about-us-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- About Us Image End -->

                        <!-- About Us Circle Start -->
                        <div class="about-us-circle">
                            <a href="<?php echo site_url('projects'); ?>">
                                <img src="images/circle-project.png" alt="">
                            </a>
                        </div>
                        <!-- About Us Circle End -->
                    </div>
                    <!-- About Us Image Box End -->
                </div>

                <div class="col-xl-6">
                    <!-- About Us Content Box Start -->
                    <div class="about-us-content-box wow fadeInUp" data-wow-delay="0.2s">
                        <!-- About Us Item List Start -->
                        <div class="about-us-item-list">
                            <!-- About Us Item Start -->
                            <div class="about-us-item box-1">
                                <!-- About Us Item Content Start -->
                                <div class="about-us-item-content">
                                    <h3>Your Trusted Partners</h3>
                                    <p>We support you at every step of your real estate journey.            </p>
                                </div>
                                <!-- About Us Item Content End -->

                                <!-- About Us Item Image Start -->
                                <div class="about-us-item-image">
                                    <figure>
                                        <img src="images/about-us-item-image-1.png" alt="">
                                    </figure>
                                </div>
                                <!-- About Us Item Image End -->
                            </div>
                            <!-- About Us Item End -->

                            <!-- About Us Item Start -->
                            <div class="about-us-item box-2">
                                <!-- About Us Item Content Start -->
                                <div class="about-us-item-content">
                                    <h3>Modern Living Solutions</h3>
                                    <p>We offer smart, functional, and modern living spaces tailored to your needs.</p>
                                </div>
                                <!-- About Us Item Content End -->

                                <!-- About Us Item Image Start -->
                                <div class="about-us-item-image">
                                    <figure class="image-anime">
                                        <img src="images/about-us-item-image-2.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- About Us Item Image End -->
                            </div>
                            <!-- About Us Item End -->
                        </div>
                        <!-- About Us Item List End -->

                        <!-- About Counter List Start -->
                        <div class="about-counter-item-list">
                            <!-- About Counter Item Start -->
                            <div class="about-counter-item">
                                <h2><span class="counter">25</span>+</h2>
                                <p>Real Estate Expertise</p>
                            </div>
                            <!-- About Counter Item End -->

                            <!-- About Counter Item Start -->
                            <div class="about-counter-item">
                                <h2><span class="counter">50</span>+</h2>
                                <p>Expert Team Members</p>
                            </div>
                            <!-- About Counter Item End -->

                            <!-- About Counter Item Start -->
                            <div class="about-counter-item">
                                <h2><span class="counter">500</span>+</h2>
                                <p>Handed-Over Project</p>
                            </div>
                            <!-- About Counter Item End -->
                        </div>
                        <!-- About Counter List End -->
                    </div>
                    <!-- About Us Content Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- About US Section End -->

    <!-- Our Service Section Start -->
    <div class="our-service bg-section dark-section">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Our Services</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Professional Real Estate <span>Services</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row service-item-list">
                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item active wow fadeInUp">
                        <!-- Service Item Image Start -->
                        <div class="service-item-image">
                            <figure>
                                <img src="images/service-1.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Service Item Image End -->

                        <!-- Service Item Body Start -->
                        <div class="service-item-body">
                            <div class="icon-box">
                                <img src="images/icon-service-item-1.svg" alt="">
                            </div>

                            <!-- Service Item Body Content Start -->
                            <div class="service-item-body-content">
                                <!-- Service Item Content Start -->
                                <div class="service-item-content">
                                    <h2><a href="<?php echo site_url('projects'); ?>">Residential Development</a></h2>
                                    <p>We create high-quality homes designed for comfortable and modern living.</p>
                                </div>
                                <!-- Service Item Content End -->

                                <!-- Service Item Button Start -->
                                <div class="service-item-btn">
                                    <a href="<?php echo site_url('projects'); ?>" class="readmore-btn">View Details</a>
                                </div>
                                <!-- Service Item Button End -->
                            </div>
                            <!-- Service Item Body Content End -->
                        </div>
                        <!-- Service Item Body End -->
                    </div>
                    <!-- Service Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Service Item Image Start -->
                        <div class="service-item-image">
                            <figure>
                                <img src="images/service-2.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Service Item Image End -->

                        <!-- Service Item Body Start -->
                        <div class="service-item-body">
                            <div class="icon-box">
                                <img src="images/icon-service-item-2.svg" alt="">
                            </div>

                            <!-- Service Item Body Content Start -->
                            <div class="service-item-body-content">
                                <!-- Service Item Content Start -->
                                <div class="service-item-content">
                                    <h2><a href="<?php echo site_url('projects'); ?>">Plot & Land Development</a></h2>
                                    <p>We develop well-planned plots in prime locations for smart investment.</p>
                                </div>
                                <!-- Service Item Content End -->

                                <!-- Service Item Button Start -->
                                <div class="service-item-btn">
                                    <a href="<?php echo site_url('projects'); ?>" class="readmore-btn">View Details</a>
                                </div>
                                <!-- Service Item Button End -->
                            </div>
                            <!-- Service Item Body Content End -->
                        </div>
                        <!-- Service Item Body End -->
                    </div>
                    <!-- Service Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Service Item Image Start -->
                        <div class="service-item-image">
                            <figure>
                                <img src="images/service-3.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Service Item Image End -->

                        <!-- Service Item Body Start -->
                        <div class="service-item-body">
                            <div class="icon-box">
                                <img src="images/icon-service-item-3.svg" alt="">
                            </div>

                            <!-- Service Item Body Content Start -->
                            <div class="service-item-body-content">
                                <!-- Service Item Content Start -->
                                <div class="service-item-content">
                                    <h2><a href="<?php echo site_url('projects'); ?>">Property Management</a></h2>
                                    <p>We ensure smooth execution with quality, timelines, and cost control.</p>
                                </div>
                                <!-- Service Item Content End -->

                                <!-- Service Item Button Start -->
                                <div class="service-item-btn">
                                    <a href="<?php echo site_url('projects'); ?>" class="readmore-btn">View Details</a>
                                </div>
                                <!-- Service Item Button End -->
                            </div>
                            <!-- Service Item Body Content End -->
                        </div>
                        <!-- Service Item Body End -->
                    </div>
                    <!-- Service Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Service Item Start -->
                    <div class="service-item wow fadeInUp" data-wow-delay="0.6s">
                        <!-- Service Item Image Start -->
                        <div class="service-item-image">
                            <figure>
                                <img src="images/service-4.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Service Item Image End -->

                        <!-- Service Item Body Start -->
                        <div class="service-item-body">
                            <div class="icon-box">
                                <img src="images/icon-service-item-4.svg" alt="">
                            </div>

                            <!-- Service Item Body Content Start -->
                            <div class="service-item-body-content">
                                <!-- Service Item Content Start -->
                                <div class="service-item-content">
                                    <h2><a href="<?php echo site_url('projects'); ?>">Planning & Design</a></h2>
                                    <p>We deliver smart designs that combine functionality and modern style.</p>
                                </div>
                                <!-- Service Item Content End -->

                                <!-- Service Item Button Start -->
                                <div class="service-item-btn">
                                    <a href="<?php echo site_url('projects'); ?>" class="readmore-btn">View Details</a>
                                </div>
                                <!-- Service Item Button End -->
                            </div>
                            <!-- Service Item Body Content End -->
                        </div>
                        <!-- Service Item Body End -->
                    </div>
                    <!-- Service Item End -->
                </div>

                
            </div>
        </div>
    </div>
    <!-- Our Service Section End -->

    <!-- Who We Are Section Start -->
    <div class="who-we-are">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Who We Are</span>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s">Shaping residential and commercial <span>spaces with expertise</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-xl-6">
                    <!-- Who We Content Start -->
                    <div class="who-we-content wow fadeInUp">
                        <!-- Our Who We Box Start -->
                        <div class="who-we-box tab-content" id="mvTabContent">
                            <!-- Sidebar Our Who We Nav start -->
                            <div class="who-we-nav">
                                <ul class="nav nav-tabs" id="mvTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="first-tab" data-bs-toggle="tab" data-bs-target="#first" type="button" role="tab" aria-controls="first" aria-selected="true"><img src="images/icon-who-we-tab-1.svg" alt=""> Property Consultants</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="second-tab" data-bs-toggle="tab" data-bs-target="#second" type="button" role="tab" aria-selected="false"><img src="images/icon-who-we-tab-2.svg" alt=""> Real Estate Advisors</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="third-tab" data-bs-toggle="tab" data-bs-target="#third" type="button" role="tab" aria-selected="false"> <img src="images/icon-who-we-tab-3.svg" alt="">Investment Experts</button>
                                    </li>
                                </ul>
                            </div>
                            <!-- Sidebar Our Mission Vision Nav End -->

                            <!-- Our who-we Tab Item Start -->
                            <div class="who-we-tab-item tab-pane fade show active" id="first" role="tabpanel">
                                <div class="who-we-tab-content">
                                    <div class="who-we-tab-header-content">
                                        <h3>Property Consultants:</h3>
                                        <p>We provide expert property consulting services to help you choose the right property based on your needs, budget, and future value. Our approach ensures clarity, trust, and the best possible decision.</p>
                                    </div>

                                    <!-- Who We Item List Start -->
                                    <div class="who-we-item-list">
                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-1.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Personalized Property Guidance</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-2.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Location-Based Recommendations</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-3.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Clear Documentation Support</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-4.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>End-to-End Assistance</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->
                                    </div>
                                    <!-- Who We Item List End -->
                                </div>
                            </div>
                            <!-- Our who-we Tab Item End -->

                            <!-- Our who-we Tab Item Start -->
                            <div class="who-we-tab-item tab-pane fade" id="second" role="tabpanel">
                                <div class="who-we-tab-content">
                                    <div class="who-we-tab-header-content">
                                        <h3>Real Estate Advisors:</h3>
                                        <p>Our experienced advisors guide you through every step of the real estate journey with transparency and market knowledge. We focus on helping you make confident and informed property decisions.</p>
                                    </div>

                                    <!-- Who We Item List Start -->
                                    <div class="who-we-item-list">
                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-1.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Expert Market Insights</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-2.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Transparent Process</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-3.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Customer-Focused Approach</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-4.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Reliable Support</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->
                                    </div>
                                    <!-- Who We Item List End -->
                                </div>
                            </div>
                            <!-- Our who-we Tab Item End -->

                            <!-- Our who-we Tab Item Start -->
                            <div class="who-we-tab-item tab-pane fade" id="third" role="tabpanel">
                                <div class="who-we-tab-content">
                                    <div class="who-we-tab-header-content">
                                        <h3>Investment Experts:</h3>
                                        <p>We help you identify the right real estate opportunities that offer strong growth and long-term value. Our team focuses on smart investments with secure and verified properties.</p>
                                    </div>

                                    <!-- Who We Item List Start -->
                                    <div class="who-we-item-list">
                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-1.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>High-Growth Location Selection</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-2.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Secure Investment Options</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-3.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Value-Driven Opportunities</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->

                                        <!-- Who We Item Start -->
                                        <div class="who-we-item">
                                            <div class="icon-box">
                                                <img src="images/icon-who-we-item-4.svg" alt="">
                                            </div>
                                            <div class="who-we-item-content">
                                                <h3>Long-Term Returns Focus</h3>
                                            </div>
                                        </div>
                                        <!-- Who We Item End -->
                                    </div>
                                    <!-- Who We Item List End -->
                                </div>
                            </div>
                            <!-- Our who-we Tab Item End -->
                        </div>
                        <!-- Our Who We Box End -->

                        <!-- Who We Footer Start -->
                        <div class="who-we-footer">
                            <div class="who-we-btn">
                                <a href="<?php echo site_url('contact'); ?>" class="btn-default">contact us</a>
                            </div>

                            <!-- About Us Contact Box Start  -->
                            <div class="about-us-contact-box">
                                <div class="icon-box">
                                    <img src="images/icon-headphone-primary.svg" alt="">
                                </div>
                                <div class="about-us-conatct-content">
                                    <p>Call Us Now!</p>
                                    <h3><a href="tel:+918110065555">+91 8110065555</a></h3>
                                </div>
                            </div>
                            <!-- About Us Contact Box End  -->
                        </div>
                        <!-- Who We Footer End -->

                    </div>
                    <!-- Who We Content End -->
                </div>

                <div class="col-xl-6">
                    <!-- Who We Image Box Start -->
                    <div class="who-we-image-box">
                        <!-- Who We Are Image Box 1 Start -->
                        <div class="who-we-image-box-1">
                            <!-- Who We Image Start -->
                            <div class="who-we-image">
                                <figure class="image-anime reveal">
                                    <img src="images/who-we-are-image-1.jpg" alt="">
                                </figure>
                            </div>
                            <!-- Who We Image End -->
                        </div>
                        <!-- Who We Image Box 1 End -->

                        <!-- Who We Are Image Box 2 Start -->
                        <div class="who-we-image-box-2">
                            <!-- Who We Cta Box Start-->
                            <div class="who-we-cta-box wow fadeInUp" data-wow-delay="0.2s">
                                <!-- Satisfy Client Images Start -->
                                <div class="satisfy-client-images">
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="images/author-1.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="images/author-2.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="images/author-3.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="images/author-4.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image add-more">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                </div>
                                <!-- Satisfy Client Images End -->

                                <!-- Who We Cta Rating Start -->
                                <div class="who-we-cta-rating">
                                    <span>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                        <i class="fa fa-solid fa-star"></i>
                                    </span>
                                </div>
                                <!-- Who We Cta Rating End -->

                                <!-- Who We Cta Content Start -->
                                <div class="who-we-cta-content">
                                    <p>Our 5k+ Satisfice Client</p>
                                </div>
                                <!-- Who We Cta Content End -->
                            </div>
                            <!-- Who We Cta Box End-->

                            <!-- Who We Image Start -->
                            <div class="who-we-image">
                                <figure class="image-anime reveal">
                                    <img src="images/who-we-are-image-2.jpg" alt="">
                                </figure>
                            </div>
                            <!-- Who We Image End -->
                        </div>
                        <!-- Who We Image Box 2 End -->
                    </div>
                    <!-- Who We Are Image Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Who We Are Section End -->

    <!-- Intro Video Start -->
    <div class="intro-video bg-section dark-section parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-md-9">
                    <!-- Intro Video Content Start -->
                    <div class="intro-video-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Watch Video</span>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Watch how we build <span>modern quality living spaces</span></h2>
                        </div>
                        <!-- Section Title End -->
                    </div>
                    <!-- Intro Video Content End -->
                </div>

                <div class="col-xl-5 col-md-3">
                    <!-- Watch Video Circle Start -->
                    <div class="watch-video-circle">
                        <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">
                            <img src="images/watch-video-circle.png" alt="">
                        </a> 
                    </div>     
                    <!-- Watch Video Circle End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Intro Video End -->

    <!-- Our Commitment Section Start -->
    <div class="our-commitment">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <!-- Our Commitment Content Start -->
                    <div class="our-commitment-content">
                        <!-- Our Commitment Header Content Start -->
                        <div class="our-commitment-header-content">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <span class="section-sub-title wow fadeInUp">Our Commitment</span>
                                <h2 class="text-anime-style-2" data-cursor="-opaque">Built on Integrity. <span>Defined by Excellence.</span></h2>
                                <p class="wow fadeInUp" data-wow-delay="0.2s">We deliver refined real estate solutions grounded in trust, transparency, and uncompromising quality. From initial consultation to final handover, every property is guided with clear processes and a commitment to long-term value.</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- Our Commitment Button Start -->
                            <div class="our-commitment-btn wow fadeInUp" data-wow-delay="0.4s">
                                <a href="<?php echo site_url('contact'); ?>" class="btn-default">Contact Us</a>
                            </div>
                            <!-- Our Commitment Button End -->
                        </div>
                        <!-- Our Commitment Header Content End -->

                        <!-- Commitment Client Box Start -->
                        <div class="commitment-client-box wow fadeInUp" data-wow-delay="0.6s">
                            <!-- Satisfy Client Images Start -->
                            
                            <!-- Satisfy Client Images End -->

                            <!-- Commitment Client Box Content Start -->
                            <div class="commitment-client-box-content">
                                <p>”Crafting modern homes and spaces with trusted real estate expertise and precision.”</p>
                            </div>
                            <!-- Commitment Client Box Content End -->
                        </div>
                        <!-- Commitment Client Box End -->
                    </div>
                    <!-- Our Commitment Content End -->
                </div>

                <div class="col-xl-7">
                    <!-- Our Commitment Item List Start -->
                    <div class="our-commitment-item-list">
                        <!-- Our Commitment Item Start -->
                        <div class="commitment-item wow fadeInUp">
                            <!-- Commitment Item Header Start -->
                            <div class="commitment-item-header">
                                <div class="icon-box">
                                    <img src="images/icon-commitment-item-1.svg" alt="">
                                </div>
                                <div class="commitment-item-title">
                                    <h3>Exceptional Craftsmanship – Precision in every detail</h3>
                                </div>
                            </div>
                            <!-- Commitment Item Header End -->

                            <!-- Commitment Item Content Start -->
                            <div class="commitment-item-content">
                                <p>We deliver exceptional craftsmanship with precise detailing and quality materials. Every space is built for durability, performance, and lasting value.</p>
                            </div>
                            <!-- Commitment Item Content End -->
                        </div>
                        <!-- Our Commitment Item End -->

                        <!-- Our Commitment Item Start -->
                        <div class="commitment-item wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Commitment Item Header Start -->
                            <div class="commitment-item-header">
                                <div class="icon-box">
                                    <img src="images/icon-commitment-item-2.svg" alt="">
                                </div>
                                <div class="commitment-item-title">
                                    <h3>Sustainable Building – Designed for durability and environmental responsibility</h3>
                                </div>
                            </div>
                            <!-- Commitment Item Header End -->

                            <!-- Commitment Item Content Start -->
                            <div class="commitment-item-content">
                                <p>We build with sustainable methods that enhance durability and efficiency. Our approach ensures minimal environmental impact and long-term value.</p>
                            </div>
                            <!-- Commitment Item Content End -->
                        </div>
                        <!-- Our Commitment Item End -->

                        <!-- Our Commitment Item Start -->
                        <div class="commitment-item wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Commitment Item Header Start -->
                            <div class="commitment-item-header">
                                <div class="icon-box">
                                    <img src="images/icon-commitment-item-3.svg" alt="">
                                </div>
                                <div class="commitment-item-title">
                                    <h3>Advanced Strategies – Innovative approaches in real estate solutions</h3>
                                </div>
                            </div>
                            <!-- Commitment Item Header End -->

                            <!-- Commitment Item Content Start -->
                            <div class="commitment-item-content">
                                <p>We use advanced strategies to enhance efficiency, clarity, and decision-making. Our innovative approach ensures better property selection, smart investments, and a seamless real estate experience.</p>
                            </div>
                            <!-- Commitment Item Content End -->
                        </div>
                        <!-- Our Commitment Item End -->
                    </div>
                    <!-- Our Commitment Item List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Commitment Section End -->

    <!-- Our Project Section Start -->
    <div class="our-project bg-section dark-section">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Our Projects</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Our work defined by precision <span>strength And Integrity</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <?php
                $home_projects = !empty($featured_properties) ? array_slice($featured_properties, 0, 4) : array();
                $delays = array('', '0.2s', '0.4s', '0.6s');
                if (!empty($home_projects)):
                    foreach ($home_projects as $idx => $proj):
                        $proj_img = get_property_image($proj);
                        $proj_url = get_property_url($proj);
                        $delay    = isset($delays[$idx]) ? $delays[$idx] : '0.6s';
                ?>
                <div class="col-xl-3 col-md-6">
                    <div class="project-item wow fadeInUp" <?php echo $delay ? 'data-wow-delay="'.$delay.'"' : ''; ?>>
                        <div class="project-item-image">
                            <a href="<?php echo $proj_url; ?>" data-cursor-text="View">
                                <figure>
                                    <img src="<?php echo $proj_img; ?>" alt="<?php echo html_escape($proj->name); ?>">
                                </figure>
                            </a>
                        </div>
                        <div class="project-item-content">
                            <?php if (!empty($proj->category)): ?>
                            <ul><li><?php echo html_escape($proj->category); ?></li></ul>
                            <?php endif; ?>
                            <h2><a href="<?php echo $proj_url; ?>"><?php echo html_escape($proj->name); ?></a></h2>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="col-12 text-center" style="padding:40px 0;color:rgba(255,255,255,0.5);">
                    <p>No featured projects yet. Mark properties as featured in the admin panel.</p>
                </div>
                <?php endif; ?>

                
            </div>
        </div>
    </div>
    <!-- Our Project Section End -->

    <!-- Our Fact Section Start -->
    <div class="our-fact">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Our Fact</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Facts that showcase experience <span>quality and reliability</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-xl-6">
                    <!-- Our Fact Image Box Start -->
                    <div class="our-fact-image-box">
                        <!-- Our Fact Image Box 1 Start -->
                        <div class="our-fact-image-box-1 wow fadeInUp">
                            <!-- Our Fact Image start -->
                            <div class="our-fact-image">
                                <figure class="image-anime">
                                    <img src="images/our-fact-image-1.jpg" alt="">
                                </figure>
                            </div>
                            <!-- Our Fact Image End -->

                            <!-- Our Fact Image Content Start -->
                            <div class="our-fact-image-content">
                                <p>“We are extremely satisfi with quality of construction and attention to detail.”</p>
                            </div>
                            <!-- Our Fact Image Content End -->
                        </div>
                        <!-- Our Fact Image Box 1 End -->

                        <!-- Our Fact Image Box 2 Start -->
                        <div class="our-fact-image-box-2">
                            <!-- Our Fact Image Start -->
                            <div class="our-fact-image">
                                <figure class="image-anime reveal">
                                    <img src="images/our-fact-image-2.jpg" alt="">
                                </figure>
                            </div>
                            <!-- Our Fact Image End -->
                        </div>
                        <!-- Our Fact Image Box 2 End -->
                    </div>
                    <!-- Our Fact Image Box End -->
                </div>

                <div class="col-xl-6">
                    <!-- Fact Item List Start -->
                    <div class="fact-item-list wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Fact Item Start -->
                        <div class="fact-item">
                            <!-- Fact Item Title Start -->
                            <div class="fact-item-title">
                                <ul>
                                    <li>Industry Expertise</li>
                                </ul>
                            </div>
                            <!-- Fact Item Title End -->

                            <!-- Fact Item Counter Start -->
                            <div class="fact-item-counter-content">
                                <h2><span class="counter">15</span>+</h2>
                                <p>Years of Experience</p>
                            </div>
                            <!-- Fact Item Counter End -->
                        </div>
                        <!-- Fact Item End -->

                        <!-- Fact Item Start -->
                        <div class="fact-item">
                            <!-- Fact Item Title Start -->
                            <div class="fact-item-title">
                                <ul>
                                    <li>Dedicated Professionals</li>
                                </ul>
                            </div>
                            <!-- Fact Item Title End -->

                            <!-- Fact Item Counter Start -->
                            <div class="fact-item-counter-content">
                                <h2><span class="counter">50</span>+</h2>
                                <p>Our Expert Team Members</p>
                            </div>
                            <!-- Fact Item Counter End -->
                        </div>
                        <!-- Fact Item End -->

                        <!-- Fact Item Start -->
                        <div class="fact-item">
                            <!-- Fact Item Title Start -->
                            <div class="fact-item-title">
                                <ul>
                                    <li>Successful Deliveries</li>
                                </ul>
                            </div>
                            <!-- Fact Item Title End -->

                            <!-- Fact Item Counter Start -->
                            <div class="fact-item-counter-content">
                                <h2><span class="counter">10</span>+</h2>
                                <p>Project Completed</p>
                            </div>
                            <!-- Fact Item Counter End -->
                        </div>
                        <!-- Fact Item End -->

                        <!-- Fact Item Start -->
                        <div class="fact-item">
                            <!-- Fact Item Title Start -->
                            <div class="fact-item-title">
                                <ul>
                                    <li>Happy Clients</li>
                                </ul>
                            </div>
                            <!-- Fact Item Title End -->

                            <!-- Fact Item Counter Start -->
                            <div class="fact-item-counter-content">
                                <h2><span class="counter">1200</span>+</h2>
                                <p>Our Trusted Owners</p>
                            </div>
                            <!-- Fact Item Counter End -->
                        </div>
                        <!-- Fact Item End -->
                    </div>
                    <!-- Fact Item List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Fact Section End -->

    <!-- Cta Box Section Start -->
    <div class="cta-box bg-section dark-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <!-- Cta Box Content Start -->
                    <div class="cta-box-content">
                        <!-- Cta Box Content Header Start -->
                        <div class="cta-box-content-header">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <span class="section-sub-title wow fadeInUp">Quick Support</span>
                                <h2 class="text-anime-style-2" data-cursor="-opaque">Quick support when you<span>need it most</span></h2>
                            </div>
                            <!-- Section Title End -->
                        </div>
                        <!-- Cta Box Content Header End -->

                        <!-- Cta Box Contact Details Start -->
                        <div class="cta-box-contact-details wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Cta Box Item Box Start -->
                            <div class="cta-item-box-list">
                                <!-- Cta Box Item Start -->
                                <div class="cta-box-item">
                                    <div class="icon-box">
                                        <img src="images/icon-cta-box-item-1.svg" alt="">
                                    </div>
                                    <div class="cta-box-item-content">
                                        <p>Call Us Now!</p>
                                        <h3><a href="tel:+918110065555">+91 8110065555</a></h3>
                                    </div>
                                </div>
                                <!-- Cta Box Item End -->

                                <!-- Cta Box Item Start -->
                                <div class="cta-box-item">
                                    <div class="icon-box">
                                        <img src="images/icon-cta-box-item-2.svg" alt="">
                                    </div>
                                    <div class="cta-box-item-content">
                                        <p>E-mail Us Now!</p>
                                        <h3><a href="mailto:enquiry@gemhousing.in">enquiry@gemhousing.in</a></h3>
                                    </div>
                                </div>
                                <!-- Cta Box Item End -->

                                <!-- Cta Location Item Start -->
                                <div class="cta-box-item">
                                    <div class="icon-box">
                                        <img src="images/icon-cta-box-item-3.svg" alt="">
                                    </div>
                                    <div class="cta-box-item-content">
                                        <p>Our Location</p>
                                        <h3>21, Rathinagiri Street, Valiyampalayam, Vilankurichi, Kalapatti – 641 035</h3>
                                    </div>
                                </div>
                                <!-- Cta Location Item End -->
                            </div>
                            <!-- Cta Box Item Box End -->                           
                        </div>
                        <!-- Cta Box Contact Details End -->
                    </div>
                    <!-- Cta Box Content End -->
                </div>

                <div class="col-xl-7">
                    <!-- Cta Form Box Start -->
                    <div class="cta-form-box">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Get In Toucht</span>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Send us a <span>message</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Cta Contact Form Start -->
                        <div class="cta-contact-form">
                            <div id="home-contact-response"></div>
                            <form id="homeContactForm" class="wow fadeInUp" data-wow-delay="0.2s" novalidate>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="message" class="form-control" rows="5" placeholder="Write Message"></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="cta-contact-form-btn">
                                            <button type="submit" class="btn-default" id="home-contact-btn"><span>Send Message</span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <script>
                        document.getElementById('homeContactForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            var fname   = this.querySelector('[name="fname"]').value.trim();
                            var lname   = this.querySelector('[name="lname"]').value.trim();
                            var email   = this.querySelector('[name="email"]').value.trim();
                            var phone   = this.querySelector('[name="phone"]').value.trim();
                            var message = this.querySelector('[name="message"]').value.trim();
                            var resp    = document.getElementById('home-contact-response');
                            var btn     = document.getElementById('home-contact-btn');

                            if (!fname || !lname || !email || !phone) {
                                resp.innerHTML = '<div style="background:#fdecea;color:#c62828;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:14px;font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Please fill in all required fields.</div>';
                                return;
                            }
                            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                                resp.innerHTML = '<div style="background:#fdecea;color:#c62828;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:14px;font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Please enter a valid email address.</div>';
                                return;
                            }

                            btn.disabled = true;
                            btn.querySelector('span').textContent = 'Sending...';
                            resp.innerHTML = '';

                            fetch('<?php echo site_url('contact/save'); ?>', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams({ name: fname+' '+lname, email: email, phone: phone, message: message }).toString()
                            })
                            .then(function(r){ return r.json(); })
                            .then(function(data){
                                if (data.success) {
                                    resp.innerHTML = '<div style="background:#e8f5e9;color:#2e7d32;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:14px;font-weight:600;"><i class="fa-solid fa-circle-check"></i> Thank you! We will contact you soon.</div>';
                                    document.getElementById('homeContactForm').reset();
                                } else {
                                    resp.innerHTML = '<div style="background:#fdecea;color:#c62828;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:14px;font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Something went wrong. Please try again.</div>';
                                }
                            })
                            .catch(function(){
                                resp.innerHTML = '<div style="background:#fdecea;color:#c62828;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:14px;font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Network error. Please try again.</div>';
                            })
                            .finally(function(){
                                btn.disabled = false;
                                btn.querySelector('span').textContent = 'Send Message';
                            });
                        });
                        </script>
                        <!-- Cta Contact Form End -->
                    </div>
                    <!-- Cta Form Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Cta Box Section End -->

    <!-- Our Faqs Section Start -->
    <div class="our-faqs">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <!-- Faqs Content Start -->
                    <div class="faqs-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Frequently Asked Questions</span>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Your questions answer <span>by our experts</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Faqs Button Start -->
                        <div class="faqs-btn wow fadeInUp" data-wow-delay="0.2s">
                            <a href="<?php echo site_url('faqs'); ?>" class="btn-default">View all FAQ's</a>
                        </div>
                        <!-- Faqs Button End -->

                        <!-- Faq Client Box Start -->
                        <div class="faq-client-box wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Satisfy Client Images Start -->
                            
                            <!-- Satisfy Client Images End -->

                            <!-- Faq Client Box Content Start -->
                            <div class="faq-client-box-content">
                                <p>Find clear, honest answers to common question from a experience professional.</p>
                            </div>
                            <!-- Faq Client Box Content End -->
                        </div>
                        <!-- Faq Client Box End -->
                    </div>
                    <!-- Faqs Content End -->
                </div>  

                <div class="col-xl-7">
                    <!-- FAQ Accordion Start -->
                    <div class="faq-accordion" id="accordion">
                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    1. How do you ensure quality in your Real estate projects?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" role="region" aria-labelledby="heading1" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>We follow strict quality standards at every stage of construction, using reliable materials and skilled professionals. Regular inspections and detailed supervision ensure that every project meets high standards of durability and finish.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    2. Do you offer customized solutions based on client needs?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" role="region" aria-labelledby="heading2" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide customized solutions tailored to your requirements, budget, and preferences. Our team works closely with clients to deliver designs that match their vision.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    3. What types of residential projects do you handle?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" role="region" aria-labelledby="heading3" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>We handle a wide range of residential projects, including individual homes, villas, and residential developments. Each project is designed to offer comfort, functionality, and modern living.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    4. How do you manage project timelines and delivery?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" role="region" aria-labelledby="heading4" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>We follow a well-planned process with clear timelines and regular progress tracking. Our team ensures timely execution through proper planning, coordination, and efficient resource management.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    5. Do you provide support for approvals and documentation?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" role="region" aria-labelledby="heading5" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we assist with necessary approvals and documentation to ensure a smooth process. Our team guides you through every step, making the entire project hassle-free.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->
                    </div>
                    <!-- FAQ Accordion End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Faqs Section End -->

    <!-- Our Testimonials Section Start-->
    <div class="our-testimonials bg-section dark-section">
        <div class="container">
             <div class="row section-row align-items-center">
                <div class="col-xl-7">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">Our Testimonials</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">What our clients say about our <span>construction services</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-xl-5">
                    <!-- Section Content Btn Start -->
                    <div class="section-content-btn">
                        <!-- Section Title Content Start -->
                        <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                            <p>Our clients' feedback reflects our commitment to quality, reliability, and professionalism.</p>
                        </div>
                        <!-- Section Title Content End -->

                        <!-- Section Button Start -->
                        <div class="section-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a class="btn-default" href="<?php echo site_url('testimonials'); ?>">View All Reviews</a>
                        </div>
                        <!-- Section Button End -->
                    </div>
                    <!-- Section Content Btn End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="gem-testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php if (!empty($testimonials)): foreach ($testimonials as $t): ?>
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                            <div class="testimonial-item-quote"><i class="fa-solid fa-quote-right"></i></div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-content"><p>"<?php echo html_escape($t->review); ?>"</p></div>
                                            <div class="testimonial-item-author">
                                                
                                                <div class="testimonial-author-content"><h3><?php echo html_escape($t->name); ?></h3><p><?php echo html_escape($t->designation); ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>
                            <div class="gem-testimonial-pagination"></div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>

                
            </div>
        </div>
    </div>
    <!-- Our Testimonials Section End-->

    <!-- Our Blog Section Start -->
    <div class="our-blog">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Latest blog</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Latest insights from real <span>estate and construction</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="<?php echo site_url('blog'); ?>" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="images/post-1.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="<?php echo site_url('blog'); ?>">Modern Construction Trends Shaping Urban Living</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="<?php echo site_url('blog'); ?>" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>

                <div class="col-xl-4 col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="<?php echo site_url('blog'); ?>" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="images/post-2.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="<?php echo site_url('blog'); ?>">Benefits Of Quality Construction For Long-Term Value</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="<?php echo site_url('blog'); ?>" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>

                <div class="col-xl-4 col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="<?php echo site_url('blog'); ?>" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="images/post-3.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="<?php echo site_url('blog'); ?>">Sustainable Building Practices For Future Ready Spaces</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="<?php echo site_url('blog'); ?>" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Blog Section End -->

    <!-- Hero Social Buttons Style -->
    <style>
        .hero-social-btns {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .hero-social-btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            transition: transform 0.25s, box-shadow 0.25s, filter 0.25s;
            letter-spacing: 0.3px;
        }
        .hero-social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.35);
            filter: brightness(1.08);
            color: #fff;
        }
        .hsb-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }
        .hsb-label { font-size: 13px; white-space: nowrap; }
        /* WhatsApp */
        .hsb-whatsapp { background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); }
        /* Facebook */
        .hsb-facebook { background: linear-gradient(135deg, #1877F2 0%, #0a58ca 100%); }
        /* Instagram */
        .hsb-instagram { background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }

        @media (max-width: 767px) {
            .hero-social-btn {
                width: 52px;
                height: 52px;
                padding: 0;
                border-radius: 50%;
                justify-content: center;
            }
            .hsb-label { display: none; }
            .hsb-icon {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background: transparent;
                font-size: 22px;
            }
        }
    </style>

    <!-- WhatsApp Floating Button Start -->
    <a href="https://wa.me/918110065555" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            z-index: 9999;
            transition: background-color 0.3s;
        }
        .whatsapp-float:hover {
            background-color: #1ebe5d;
            color: #fff;
        }
    </style>
    <!-- WhatsApp Floating Button End -->

<!-- Testimonial Slider Init -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.gem-testimonial-slider .swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        speed: 800,
        grabCursor: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.gem-testimonial-pagination',
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 },
        }
    });
});
</script>

