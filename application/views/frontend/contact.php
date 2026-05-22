<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!-- Page Header Section Start -->
    <div class="page-header-contact bg-section parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Contact us</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo site_url('contact'); ?>">Contact Us</a></li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <!-- Contact Us Content Start -->
                    <div class="contact-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Contact Us</span>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">We're ready to build your <span>future together</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We partner with you to plan, design, and deliver high-quality construction projects with transparency, expertise, and a commitment to long-term value.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Contact Info List Start -->
                        <div class="contact-info-list">
                            <!-- Contact Info Item Start -->
                            <div class="contact-info-item wow fadeInUp">
                                <h2><a href="mailto:enquiry@gemhousing.in">enquiry@gemhousing.in</a></h2>
                                <h3><a href="tel:+918110065555">+91 8110065555</a></h3>
                            </div>
                            <!-- Contact Info Item End -->

                            <!-- Contact Info Item Start -->
                            <div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
                                <h4>Address:</h4>
                                <p>21, Rathinagiri Street, Valiyampalayam, Vilankurichi, Kalapatti – 641 035</p>
                            </div>
                            <!-- Contact Info Item End -->

                            <!-- Contact Us Social List Start -->
                            <div class="contact-us-social-list wow fadeInUp" data-wow-delay="0.4s">
                                 <ul>
                                    <li><a href="https://www.youtube.com/@GemHousing" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a></li>
                                    <li><a href="https://www.facebook.com/gemhousing/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.instagram.com/gem_housing/" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <!-- Contact Us Social List End -->
                        </div>
                        <!-- Contact Info List End -->
                    </div>
                    <!-- Contact Us Content End -->
                </div>

                <div class="col-xl-7">
                    <!-- Contact Form Start -->
                    <div class="contact-form">

                        <!-- Flash messages -->
                        <?php if ($this->session->flashdata('success')): ?>
                        <div class="contact-alert contact-alert-success">
                            <i class="fa-solid fa-circle-check"></i> <?php echo $this->session->flashdata('success'); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="contact-alert contact-alert-error">
                            <i class="fa-solid fa-circle-exclamation"></i> <?php echo $this->session->flashdata('error'); ?>
                        </div>
                        <?php endif; ?>

                        <div id="contact-response"></div>

                        <form id="contactForm" class="wow fadeInUp" data-wow-delay="0.4s" novalidate>
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <label>First Name <span class="req">*</span></label>
                                    <input type="text" name="fname" class="form-control" placeholder="Enter First Name" required>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label>Last Name <span class="req">*</span></label>
                                    <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" required>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label>Email Address <span class="req">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label>Phone Number <span class="req">*</span></label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                                </div>

                                <div class="form-group col-md-12 mb-4">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Enter Subject">
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" rows="5" placeholder="Your message..."></textarea>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn-default" id="contact-submit-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Form End -->
                </div>

                <style>
                .req { color: #e53935; }
                .contact-alert {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 14px 18px;
                    border-radius: 10px;
                    font-size: 15px;
                    font-weight: 600;
                    margin-bottom: 20px;
                }
                .contact-alert-success { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #28a745; }
                .contact-alert-error   { background: #fdecea; color: #c62828; border-left: 4px solid #e53935; }
                #contact-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }
                </style>

                <script>
                document.getElementById('contactForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    var fname   = this.querySelector('[name="fname"]').value.trim();
                    var lname   = this.querySelector('[name="lname"]').value.trim();
                    var email   = this.querySelector('[name="email"]').value.trim();
                    var phone   = this.querySelector('[name="phone"]').value.trim();
                    var subject = this.querySelector('[name="subject"]').value.trim();
                    var message = this.querySelector('[name="message"]').value.trim();
                    var resp  = document.getElementById('contact-response');
                    var btn   = document.getElementById('contact-submit-btn');

                    // Basic validation
                    if (!fname || !lname || !email || !phone) {
                        resp.innerHTML = '<div class="contact-alert contact-alert-error"><i class="fa-solid fa-circle-exclamation"></i> Please fill in all required fields.</div>';
                        return;
                    }
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        resp.innerHTML = '<div class="contact-alert contact-alert-error"><i class="fa-solid fa-circle-exclamation"></i> Please enter a valid email address.</div>';
                        return;
                    }

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
                    resp.innerHTML = '';

                    var body = new URLSearchParams({
                        name:    fname + ' ' + lname,
                        email:   email,
                        phone:   phone,
                        subject: subject,
                        message: message
                    }).toString();

                    fetch('<?php echo site_url('contact/save'); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: body
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success) {
                            resp.innerHTML = '<div class="contact-alert contact-alert-success"><i class="fa-solid fa-circle-check"></i> ' + data.message + '</div>';
                            document.getElementById('contactForm').reset();
                        } else {
                            var errMsg = data.message || 'Something went wrong. Please try again.';
                            resp.innerHTML = '<div class="contact-alert contact-alert-error"><i class="fa-solid fa-circle-exclamation"></i> ' + errMsg + '</div>';
                        }
                    })
                    .catch(function() {
                        resp.innerHTML = '<div class="contact-alert contact-alert-error"><i class="fa-solid fa-circle-exclamation"></i> Network error. Please try again.</div>';
                    })
                    .finally(function() {
                        btn.disabled = false;
                        btn.innerHTML = 'Send Message';
                        resp.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    });
                });
                </script>
            </div>
        </div>
    </div>
    <!-- Page Contact Us End -->

    <!-- Google Map Start -->
    <div class="google-map">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Our Location</span>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Find Us at <span>Our Office</span></h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">21, Rathinagiri Street, Valiyampalayam, Vilankurichi, Kalapatti – 641 035, Coimbatore, Tamil Nadu.</p>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Google Map Start -->
                    <div class="google-map-iframe wow fadeInUp" data-wow-delay="0.4s">
                        <iframe src="https://maps.google.com/maps?q=21+Rathinagiri+Street+Valiyampalayam+Vilankurichi+Kalapatti+641035+Coimbatore&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- Google Map End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map End -->
