  <!-- Vendor JS Files --> 
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/aos/aos.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/waypoints/noframework.waypoints.js"></script> 

  <!-- Template Main JS File -->
  <script src="<?php echo base_url('theme/front/shine-trades/') ?>assets/js/main.js"></script>
  
  <!--jquery and slick-slider-->
  
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>-->
             <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
             <script>
                 $('.logo-slider').slick({
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     dots: true,
                     arrows: true,
                     autoplay: true,
                     autoplaySpeed: 500,
                     infinite: true,
                     responsive: [
                        {
                          breakpoint: 1024,
                          settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                          }
                        },
                        {
                          breakpoint: 600,
                          settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                          }
                        },
                        {
                          breakpoint: 480,
                          settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false
                          }
                        }
                      ]

                     
                 });
                 
                 $('.service-slider').slick({
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     dots: true,
                     arrows: true,
                     autoplay: true,
                     autoplaySpeed: 1500,
                     infinite: true,
                     responsive: [
                        {
                          breakpoint: 1024,
                          settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                          }
                        },
                        {
                          breakpoint: 600,
                          settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                          }
                        },
                        {
                          breakpoint: 480,
                          settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false
                          }
                        }
                      ]

                     
                 });
             </script>
  
  <script>
      $(document).ready(function() {
          $(document).off('click','.clse').on('click','.clse',function(e){
              e.preventDefault();
              $(this).parent().parent().parent().remove();
          });
      });
  </script>