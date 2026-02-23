    <?php
        $site_settings = $this->session->userdata('site_settings'); 
        $menu = $this->crud_model->get_where_order_by('contents',array('status'=>'1','show_on_menu'=>'Yes','parent_id'=>0),'order_no','ASC');
    ?>
    <style>
        .row.flsh_message h4 {
            /* float: left; */
            font-size: 18px;
            margin-right: 10px;
        }
        
        .row.flsh_message {
            background: #ddd;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        
        .row.flsh_message .clse {
            position: absolute;
            top: 0;
            right: 20px;
            cursor: pointer;
        }
        
        .row.flsh_message div div.success_message h4 {
            /* float: left; */
            font-size: 18px;
            margin-right: 10px;
            color:#40d15f;
        }
        .row.flsh_message div div.error_message h4 {
            /* float: left; */
            font-size: 18px;
            margin-right: 10px;
            
            color:#e16208;
        } 
    </style>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">
    
          <!-- Uncomment below if you prefer to use an image logo -->
          <a href="<?php echo base_url(); ?>" class="logo me-auto"><img src="<?php echo $site_settings->logo; ?>" alt="shine" class="img-fluid"></a>
    
          <nav id="navbar" class="navbar">
            <ul>
                <?php 
                $controller_name = $this->router->fetch_class();
                if($controller_name != 'home'){ ?>
                    <li><a class="nav-link scrollto active" href="<?php echo base_url('').'#hero' ?>">Home</a></li> 
                <?php
                }else{
                ?>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <?php
                }
                ?>
              
              <?php
              if($menu){
                 
                  foreach($menu as $key=>$value){
                        $controller_name = $this->router->fetch_class();
                        //   var_dump($controller_name);exit;
                        if($controller_name != 'home'){
                            //  $href = base_url('');
                             if($value->slug=='services'){
                                  $href = base_url('').'#services';
                              }else if($value->slug=='clients'){
                                  $href = base_url('').'#clients';
                              }else if($value->slug=='news-articles'){
                                  $href = base_url('').'#news';
                              }else if($value->slug=='contact-us'){
                                  $href = base_url('').'#contact';
                              }else{
                                  $href= ''; 
                              }
                        }else{
                             if($value->slug=='services'){
                                  $href = '#services';
                              }else if($value->slug=='clients'){
                                  $href = '#clients';
                              }else if($value->slug=='news-articles'){
                                  $href = '#news';
                              }else if($value->slug=='contact-us'){
                                  $href = '#contact';
                              }else{
                                  $href= ''; 
                              }
                        } 
                      
                      $sub_menu = $this->crud_model->get_where_order_by('contents',array('status'=>'1','show_on_menu'=>'Yes','parent_id'=>$value->id),'order_no','ASC');
                      if(empty($sub_menu)){
                ?>          
                        <li><a class="nav-link scrollto" href="<?php echo $href; ?>"><?php echo $value->title; ?></a></li>
                <?php          
                      }else{
                ?> 
                        <li class="dropdown"><a href="#"><span><?php echo $value->title; ?></span> <i class="bi bi-chevron-down"></i></a>
    
                            <ul>
                              
                                <?php 
                                    foreach($sub_menu as $key_sub => $value_sub) { 
                                        $sub_menu_second = $this->crud_model->get_where_order_by('contents',array('status'=>'1','show_on_menu'=>'Yes','parent_id'=>$value_sub->id),'order_no','ASC');
                                        if(empty($sub_menu_second)){
                                ?>
                                            <li><a href="<?php echo (isset($value_sub->external_url) && $value_sub->external_url != '')? $value_sub->external_url:base_url('content/detail/'.$value_sub->slug)?>"><?php echo $value_sub->title; ?></a></li>
                                    
                                <?php 
                                        } else{
                                ?>
                                
                                            <li class="dropdown"><a href="#"><span><?php echo $value_sub->title; ?></span> <i class="bi bi-chevron-right"></i></a>
                                                <ul>
                                <?php
                                            echo $this->crud_model->menuTree($value_sub->id);  
                                ?>
                                                </ul>
                                            </li>
                                <?php
                                    }   } 
                                ?>  
                
                            </ul>
                
                        </li>
              <?php } } }?> 
              
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->
    
        </div>  
        <!--flash message-->
        <?php if($this->session->flashdata('success')){ ?>
          <div class="row flsh_message"> 
            <div class="col-sm-12">
              <div class="success_message">  
                  <h4><?php echo $this->session->flashdata('success'); ?></h4>
                  <a class="clse">X</a>
              </div> 
            </div> 
          </div> 
          <?php } ?>
          <?php if($this->session->flashdata('error')){ ?>
          <div class="row flsh_message"> 
            <div class="col-sm-12">
              <div class="error_message"> 
                  <h4><?php echo $this->session->flashdata('error'); ?></h4>
                  <a class="clse">X</a>
              </div> 
            </div> 
          </div> 
          <?php } ?>
          <?php if(validation_errors()){ ?>
          <div class="row flsh_message"> 
            <div class="col-sm-12">
              <div class="error_message">  
                  <h4><?php echo validation_errors(); ?></h4>
                  <a class="clse">X</a>
              </div> 
            </div> 
          </div> 
        <?php } ?>
        
        <!--flash message end-->
    </header>
  <!-- End Header --> 