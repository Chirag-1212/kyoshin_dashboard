<head>
    <?php
        $site_settings = $this->session->userdata('site_settings'); 
    ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Shine Trade Nepal | <?php echo ($title)? $title : 'Home' ?></title> 
  
  <meta name="title" content="<?php echo (isset($meta_title)&&$meta_title!='')? $meta_title:$site_settings->meta_title; ?>">
  <meta name="description" content="<?php echo (isset($meta_description)&&$meta_description!='')? $meta_description:substr(strip_tags($site_settings->meta_description), 0, 300); ?>">
  <meta name="keywords" content="<?php echo (isset($meta_keywords)&&$meta_keywords!='')? $meta_keywords:$site_settings->meta_key_words; ?>"> 

  <!-- Favicons -->
  <link href="<?php echo $site_settings->fav; ?>" rel="icon">
  <link href="<?php echo $site_settings->fav; ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  
    <!--slick-slider cdn-->
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
        <link rel="stylesheet" type="text/css" href="    https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">


  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/css/blogStyle.css" rel="stylesheet">
  <link href="<?php echo base_url('theme/front/shine-trades/') ?>assets/css/portfolioStyle.css" rel="stylesheet">
</head>