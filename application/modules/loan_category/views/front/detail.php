<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $title; ?></h2>
          <ol>
            <li><a href="<?php echo base_url(''); ?>">Home</a></li>
            <li><?php echo $title; ?></li>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                  <img src="<?php echo $detail->featured_image; ?>" alt="">
                </div>
                
              </div>
              <div class="portfolio-description">
                  <h2><?php echo $title; ?></h2>
                  <p>
                     <?php echo $detail->description; ?>
                  </p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Contact</h3>
              <ul>
                <li><strong>Slogan</strong>: <?php echo $site_settings->site_slogan; ?></li>
                <li><strong>Address</strong>: <?php echo $site_settings->address; ?></li>
                <li><strong>Phone</strong>: <?php echo $site_settings->mobile; ?>, <?php echo $site_settings->telephone; ?></li>
                <li><strong>Email</strong>: <?php echo $site_settings->email; ?></li>
                <li><strong>Web URL</strong>: <a href="<?php echo base_url(''); ?>" style="color: #E35335;">shine.com.np</a></li>
              </ul>
            </div> 
            <div class="portfolio-description"> 
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7065.601572600965!2d85.3186592!3d27.6925514!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19b0fdbc7517%3A0xcbc86669773a3933!2sNyatapol%20Technologies%20Pvt.%20Ltd.!5e0!3m2!1sen!2snp!4v1645084848782!5m2!1sen!2snp" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen="" loading="lazy"></iframe>
              </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->