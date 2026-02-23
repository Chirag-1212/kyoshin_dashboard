<!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1><?php echo $slider->title ?></h1>
          <h2><?php echo $slider->sub_title; ?></h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="<?php echo base_url('content/detail/about-us'); ?>" class="btn-get-started scrollto">About Us</a>
            <a href="<?php echo $slider->youtube_link ?>" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="<?php echo $slider->featured_image; ?>" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

    <main id="main">
    <?php 
        if($services){ 
            $service_menu_detail = $this->crud_model->get_where_single_order_by('contents',array('status'=>'1','id'=>5),'id','DESC');
            if($service_menu_detail){
    ?>
    
    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg portfolio ">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2><?php echo $service_menu_detail->title; ?></h2>
          <p><?php echo $service_menu_detail->description; ?></p>
        </div>

        <div class="row">
            <div class="service-slider">
                <?php 
                    foreach($services as $key=>$value){ 
                        if($key==0){
                            $data_aos_delay = 100;
                        }else if($key==1){
                            $data_aos_delay = 200;
                        }else if($key==2){
                            $data_aos_delay = 300;
                        }else{ 
                            $data_aos_delay = 400; 
                        }
                        
                ?> 
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0 srvc-slider" data-aos="zoom-in" data-aos-delay="<?php echo $data_aos_delay; ?>">
                        <div class="icon-box">
                          <div class="icon"><i class="<?php echo $value->icon_class; ?>"></i></div>
                          <h4><a href="<?php echo base_url('').'service/detail/'.$value->slug ?>"><?php echo $value->title; ?></a></h4>
                          <p><?php echo substr(strip_tags($value->description), 0, 85); ?></p>
                        </div>
                    </div> 
                <?php } ?>
            </div>
        </div> 
        <a type="button" href="<?php echo base_url('service/all') ?>" class="btn-all-news">Browse All</a>
      </div>
      
    </section><!-- End Services Section -->
    
    <?php } } ?>
    

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="row">
          <div class="col-lg-9 text-center text-lg-start">
            <h3>Call To Action</h3>
            <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="#contact">Call To Action</a>
          </div>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <?php 
        if($clients){ 
            $client_menu_detail = $this->crud_model->get_where_single_order_by('contents',array('status'=>'1','id'=>6),'id','DESC');
            if($client_menu_detail){
    ?>
    <section id="clients" class="clients section-bg">
          <div class="container">

            <div class="section-title">
                <h2><?php echo $client_menu_detail->title; ?></h2>
                <p><?php echo $client_menu_detail->description; ?></p>
            </div>
            
                        <!--========== Clients with slick slider ==========-->
        <div class="container1">
              <!-- <h1>Our Popular Brand</h1> -->
            <div class="logo-slider">
                <?php foreach($clients as $key=>$value){ ?>
              <div class="item">
                  <a><img src="<?php echo $value->featured_image; ?>"></a>
              </div>
              <?php } ?> 
            </div>
        </div>
        
    
          </div>
        </section>
    
    <!-- End Cliens Section --> 
    <?php } } ?>
    
        <!-- ======= Clients with slick-slider Section ======= -->
                
    
    <?php 
        if($portfolios){ 
            $portfolio_menu_detail = $this->crud_model->get_where_single_order_by('contents',array('status'=>'1','id'=>13),'id','DESC');
            if($portfolio_menu_detail){
    ?>
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio" data-aos="fade-up">
      <div class="container">
        <div class="section-title">
          <h2><?php echo $portfolio_menu_detail->title; ?></h2>
          <p><?php echo $portfolio_menu_detail->description; ?></p>
        </div>
      </div>
      <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">
        <div data-portfolio-layout="masonry" data-portfolio-sort="original-order">
          <div   class="row g-0 portfolio-container">
            <?php foreach($portfolios as $key=>$value){ ?>
            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
              <img src="<?php echo $value->featured_image; ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo $value->title; ?></h4>
                <a href="<?php echo $value->featured_image; ?>" title="<?php echo $value->title; ?>" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="<?php echo base_url('').'portfolio/detail/'.$value->slug ?>" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <?php } ?> 
          </div><!-- End Portfolio Container -->
          <a type="button" href="<?php echo base_url('portfolio/all') ?>" class="btn-all-news">Browse All Works</a>
        </div>
      </div>
    </section><!-- End Portfolio Section -->
    
    <?php } } ?>
    <?php 
        if($news){ 
            $news_menu_detail = $this->crud_model->get_where_single_order_by('contents',array('status'=>'1','id'=>7),'id','DESC');
            if($news_menu_detail){
    ?>
    <!-- ======= Recent Blog Posts Section ======= -->
    <section id="news" class="recent-blog-posts">

      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2><?php echo $news_menu_detail->title; ?></h2>
          <p><?php echo $news_menu_detail->description; ?></p>
        </div>

        <div class="row">
            <?php foreach($news as $key=>$value){ ?>        
          <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="<?php if($key==0){echo 200;}else if($key==400){echo 400;}else{echo 600;} ?>">
            <div class="post-box">
              <div class="post-img"><img src="<?php echo $value->featured_image; ?>" class="img-fluid" alt=""></div>
              <div class="meta">
                <span class="post-date">
                    <?php
                        $date=date_create($value->created);
                        echo date_format($date,"D, F d");
                    ?>
                </span>
                <span class="post-author"> / <?php echo $value->author; ?></span>
              </div>
              <h3 class="post-title"><?php echo $value->title; ?></h3>
              <p><?php echo substr(strip_tags($value->description), 0, 150); ?></p>
              <a href="<?php echo base_url('blog/detail/'.$value->slug); ?>" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
          <?php } ?>  
        </div>
        <a type="button" href="<?php echo base_url('blog/all'); ?>" class="btn-all-news">Browse All</a>

      </div>

    </section>
    <!-- End Recent Blog Posts Section -->
    <?php } }?>
    
    <?php if($site_settings){
        $contact_menu_detail = $this->crud_model->get_where_single_order_by('contents',array('status'=>'1','id'=>2),'id','DESC');
        if($contact_menu_detail){
     ?>
            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
              <div class="container" data-aos="fade-up">
        
                <div class="section-title">
                  <h2><?php echo $contact_menu_detail->title; ?></h2>
                  <p><?php echo $contact_menu_detail->description; ?></p>
                </div>
        
                <div class="row">
        
                  <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                      <div class="address">
                        <i class="bi bi-geo-alt"></i>
                        <h4>Location:</h4>
                        <p><?php echo $site_settings->address; ?></p>
                      </div>
        
                      <div class="email">
                        <i class="bi bi-envelope"></i>
                        <h4>Email:</h4>
                        <p><?php echo $site_settings->email; ?></p>
                      </div>
        
                      <div class="phone">
                        <i class="bi bi-phone"></i>
                        <h4>Call:</h4>
                        <p><?php echo $site_settings->telephone; ?>, <?php echo $site_settings->mobile; ?></p>
                      </div>
                      <?php //echo $site_settings->map_location; ?>
                      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7065.601572600965!2d85.3186592!3d27.6925514!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19b0fdbc7517%3A0xcbc86669773a3933!2sNyatapol%20Technologies%20Pvt.%20Ltd.!5e0!3m2!1sen!2snp!4v1645084848782!5m2!1sen!2snp" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen="" loading="lazy"></iframe>
                      <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>-->
                    </div>
        
                  </div>
        
                  <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="<?php echo base_url('home/save_contact_message'); ?>" method="post"  class="php-email-form">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="name">Your Name</label>
                          <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="name">Your Email</label>
                          <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name">Subject</label>
                        <input type="text" class="form-control" name="subject" id="subject" required>
                      </div>
                      <div class="form-group">
                        <label for="name">Message</label>
                        <textarea class="form-control" name="message" rows="10" required></textarea>
                      </div>
                      <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                      </div>
                      <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                  </div>
        
                </div>
        
              </div>
            </section><!-- End Contact Section -->
    <?php } }?> 

  </main><!-- End #main -->