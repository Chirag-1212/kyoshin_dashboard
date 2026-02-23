<?php
    $site_settings = $this->session->userdata('site_settings'); 
    $footer_menu = $this->db->order_by('order_no', 'ASC')->get_where('contents',array('parent_id'=>0,'status'=>'1','show_on_footer_menu'=>'Yes'))->result();
    $services = $this->crud_model->get_where_pagination('services',array('status'=>'1'),5,0);
?>
<!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Stay with us for latest updates !!!</p>
            <form action="<?php echo base_url('home/subscribe'); ?>" method="post"  class="php-email-form">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><?php echo $site_settings->site_name; ?></h3>
            <p>
              <?php echo $site_settings->contact_detail; ?>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>">Home</a></li> 
              <?php foreach($footer_menu as $key=>$value){ ?>
                    <li><i class="bx bx-chevron-right"></i> <a href="<?php echo (isset($value->type) && $value->type == 'others') ? $value->external_url : base_url('').'content/detail/'.$value->slug; ?>"><?php echo $value->title ?></a></li>
              <?php } ?> 
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
                <?php foreach($services as $key=>$value){ ?>
                    <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url().'service/detail/'.$value->slug; ?>"><?php echo $value->title ?></a></li>
                <?php } ?> 
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4> 
            <div class="social-links mt-3">
              <a href="<?php echo $site_settings->twitter ?>" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="<?php echo $site_settings->facebook ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="<?php echo $site_settings->instagram ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="<?php echo $site_settings->skype ?>" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="<?php echo $site_settings->linked_in ?>" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span><?php echo $site_settings->site_name; ?></span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Developed by <a href="http://www.nt.com.np/">Nyatapol Technologies</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>