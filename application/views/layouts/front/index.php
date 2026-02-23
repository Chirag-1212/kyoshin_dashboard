<!DOCTYPE html>
<html lang="en">
    <?php
        $site_settings = $this->session->userdata('site_settings'); 
    ?>
    <!--head section-->
    <?php $this->load->view('layouts/front/partials/head'); ?>
    <!--head section end-->
<body>

    <!--header section start--> 
    <?php $this->load->view('layouts/front/partials/header'); ?> 
    <!--header section end--> 
    
    <!--pages start-->
    <?php $this->load->view($page); ?>
    <!--pages end--> 

    <!--footer start-->
    <?php $this->load->view('layouts/front/partials/footer'); ?> 
    <!--footer end--> 
    
    <!--scripts start-->
    <?php $this->load->view('layouts/front/partials/script'); ?> 
    <!--scripts end-->

</body>

</html>