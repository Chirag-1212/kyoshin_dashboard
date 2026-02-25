<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        $uri1 = $this->uri->segment(1);
        $uri3 = $this->uri->segment(3);
       
        ?>
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(). $staff_featured_image; ?>" class="img-circle"
                    alt="<?php echo $site_settings->short_name ?>">
            </div>
            <div class="pull-left info">
                <p><?php echo $staff_name; ?></p>
                <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>


        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo isset($dashboard)? 'active' : ''; ?>">
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php
                $check_menu = $this->crud_model->get_module_for_role('content');
                if ($check_menu == true) {
                ?>

            <li>
                <a href="<?php echo base_url('content/admin/menu'); ?>">
                    <i class="fa fa-th"></i> <span>Menu</span>
                </a>
            </li>
            <?php 
                } ?>
            <?php
                $check_content = $this->crud_model->get_module_for_role('contents');
                if ($check_content == true) {
                ?>

            <li class="<?php echo isset($module)?($module == 'Content'?'active':''):'' ?>">
                <a href="<?php echo base_url('content/admin/all'); ?>">
                    <i class="fa fa-bars"></i> <span>Content</span>
                </a>
            </li>
            <?php 
            } ?>
             <?php
                $check_banner = $this->crud_model->get_module_for_role('banner');
                if ($check_banner == true) {
                ?>

            <li class="treeview <?php echo isset($banner)? 'active' :''; ?>">
                <a href="#">
                    <i class="fa fa-sticky-note-o"></i>
                    <span>Banner</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                      $check_banner_all = $this->crud_model->get_module_function_for_role('banner', 'all');
                      if ($check_banner_all == true) {
                      ?>
                    <li class="<?php echo isset($banner)? ($banner == 'banner-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('banner/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php 
                        } 
                        
                        $check_banner_form = $this->crud_model->get_module_function_for_role('banner', 'form');
                        if ($check_banner_form == true) {
                        ?>
                    <li class="<?php echo isset($banner)? ($banner == 'banner-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('banner/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php  } ?>
                </ul>
            </li>

            <?php 
                } 
         ?>
          
            
            <?php
            $check_csr = $this->crud_model->get_module_for_role('csr');
            if ($check_csr == true) {
            ?>

            <li class="treeview <?php echo isset($csr)?  'active': ''; ?>">
                <a href="#">
                    <i class="fa fa-trophy"></i> <span>CSR</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_csr_all = $this->crud_model->get_module_function_for_role('csr', 'all');
                    if ($check_csr_all == true) {
                    ?>
                    <li class="<?php echo isset($csr)? ($csr == 'csr-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('csr/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_csr_form = $this->crud_model->get_module_function_for_role('csr', 'form');
                    if ($check_csr_form == true) {
                    ?>
                    <li class="<?php echo isset($csr)? ($csr == 'csr-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('csr/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>
                    </li>

                    <?php } ?>

                </ul>
            </li>

            <?php } ?>

            <?php
            $check_service = $this->crud_model->get_module_for_role('service');
            if ($check_service == true) {
            ?>
            <li class="treeview <?php echo isset($service)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Services</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    // $check_service_cat_all = $this->crud_model->get_module_function_for_role('service_category', 'all');
                    // if ($check_service_cat_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($service)? ($service == 'service-category' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('service_category/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Service Category</a>-->
                    <!--</li>-->
                    <?php //} ?>
                    <?php
                    $check_service_all = $this->crud_model->get_module_function_for_role('service', 'all');
                    if ($check_service_all == true) {
                    ?>
                    <li class="<?php echo isset($service)? ($service == 'service-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('service/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php 
                        } 
                        
                        $check_services_form = $this->crud_model->get_module_function_for_role('service', 'form');
                        if ($check_services_form == true) {
                        ?>
                    <li class="<?php echo isset($service)? ($service == 'service-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('service/admin/form'); ?>"><i class="fa fa-circle-o"></i>
                            Add</a>
                    </li>
                    <?php  } ?>
                </ul>
            </li>
            <?php } ?>
            <?php
            // $check_digital_service = $this->crud_model->get_module_for_role('digital_services');
            // if ($check_digital_service == true) {
            ?>
            <!--<li class="treeview <?php echo isset($digital_service)?  'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa  fa-desktop"></i> <span> Digital Service</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check__digital_service_all = $this->crud_model->get_module_function_for_role('digital_services', 'all');
                    // if ($check__digital_service_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($digital_service)? ($digital_service == 'digital_service-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('digital_services/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_digital_service_form = $this->crud_model->get_module_function_for_role('digital_services', 'form');
                    // if ($check_digital_service_form == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($digital_service)? ($digital_service == 'digital_service-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('digital_services/admin/form'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Add New</a>-->
                    <!--</li>-->

                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->

            <?php //} ?>
            <?php
            // $check_popup = $this->crud_model->get_module_for_role('popup');
            // if ($check_popup == true) {
            ?>
            <!--<li class="treeview <?php echo isset($popup)? 'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-fighter-jet"></i> <span>Popup</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_popup_all = $this->crud_model->get_module_function_for_role('popup', 'all');
                    // if ($check_popup_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($popup)? ($popup == 'popup-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('popup/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_popup_form = $this->crud_model->get_module_function_for_role('popup', 'form');
                    // if ($check_popup_form == true) {
                    ?>
                    <!--<li class="<?php echo isset($popup)? ($popup == 'popup-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('popup/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>-->
                    <!--</li>-->

                    <?php //} ?>

            <!--    </ul>-->
            <!--</li>-->

            <?php //} ?>
            <?php
            // $check_faq = $this->crud_model->get_module_for_role('faq');
            // if ($check_faq == true) {
            ?>
            <!--<li class="treeview <?php echo isset($faq)? 'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-question-circle"></i> <span>FAQ</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_faq_all = $this->crud_model->get_module_function_for_role('faq', 'all');
                    // if ($check_faq_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($faq)? ($faq == 'faq-category' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('faq_category/admin/all'); ?>"><i class="fa fa-circle-o"></i> Faq-->
                    <!--        Category</a>-->
                    <!--</li>-->
                    <!--<li class="<?php echo isset($faq)? ($faq == 'faq-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('faq/admin/all'); ?>"><i class="fa fa-circle-o"></i> Faq List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_faq_form = $this->crud_model->get_module_function_for_role('faq', 'form');
                    // if ($check_faq_form == true) {
                    ?>
                    <!--<li class="<?php echo isset($faq)? ($faq == 'faq-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('faq/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>-->
                    <!--</li>-->

                    <?php //} ?>

            <!--    </ul>-->
            <!--</li>-->
            <?php //} ?>
            <?php
            $check_notice_career  = $this->crud_model->get_module_for_role('notice_career');
            if ($check_notice_career  == true) {
            ?>

            <li class="treeview <?php echo isset($notice)? 'active': ''; ?>">
                <a href="#">
                    <i class="fa fa-bell-o"></i> <span>News&Event/Notice/Career</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_notice_career_all = $this->crud_model->get_module_function_for_role('notice_career', 'all');
                    if ($check_notice_career_all == true) {
                    ?>
                    <li class="<?php echo isset($notice)? ($notice == 'notice-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('notice_career/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_notice_career_form = $this->crud_model->get_module_function_for_role('notice_career', 'form');
                    if ($check_notice_career_form == true) {
                    ?>
                    <li class="<?php echo isset($notice)? ($notice == 'notice-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('notice_career/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>

                    <?php } ?>

                </ul>
            </li>

            <?php } ?>
            <li class="<?php echo isset($module)?($module == 'CareerApply'?'active':''):'' ?>">
                <a href="<?php echo base_url('CareerApply/admin/all'); ?>">
                    <i class="fa fa-briefcase"></i> <span>Career Apply</span>
                </a>
            </li>
           
            <?php 
                
            $check_epayment_partners = $this->crud_model->get_module_function_for_role('epayment_partners', 'all');
            if ($check_epayment_partners == true) {
            ?>
            <!--<li class="<?php echo isset($epayment_partners)? 'active' : ''; ?>">-->
            <!--    <a href="<?php echo base_url('epayment_partners/admin/all'); ?>">-->
            <!--        <i class="fa fa-money"></i> <span>E-Payment Partners</span>-->
            <!--    </a>-->
            <!--</li>-->
            <?php } ?>
            
            <?php
            // $check_forex = $this->crud_model->get_module_function_for_role('forex', 'all');
            // if ($check_forex == true) {
            ?>
            <!--<li class="<?php echo isset($forex)? 'active' : ''; ?>">-->
            <!--    <a href="<?php echo base_url('forex/admin/all'); ?>">-->
            <!--        <i class="fa fa-th"></i> <span>Forex</span>-->
            <!--    </a>-->
            <!--</li>-->
            <?php //} ?>
            <?php
            // $check_grievance = $this->crud_model->get_module_for_role('grievance');
            // if ($check_grievance == true) {
            ?>
            <!--<li class="<?php echo isset($grievance)? 'active' : ''; ?>">-->
            <!--    <a href="<?php echo base_url('grievance/admin/all'); ?>">-->
            <!--        <i class="fa fa-th"></i> <span>Grievance</span>-->
            <!--    </a>-->
            <!--</li>-->
            <?php //} ?>
            <?php
            $check_feedback = $this->crud_model->get_module_for_role('feedback');
            if ($check_feedback == true) {
            ?>
            <li class="<?php echo isset($feedback)? 'active' : ''; ?>">
                <a href="<?php echo base_url('feedback/admin/all'); ?>">
                    <i class="fa fa-th"></i> <span>Feedback</span>
                </a>
            </li>
            <?php } ?>
             <?php
            $check_bank_guarantee = $this->crud_model->get_module_for_role('bank_guarantee');
            if ($check_bank_guarantee == true) {
            ?>
            <li class="<?php echo isset($bank_guarantee)? 'active' : ''; ?>">
                <a href="<?php echo base_url('bank_guarantee/admin/all'); ?>">
                    <i class="fa fa-th"></i> <span>Bank Guarantee</span>
                </a>
            </li>
            <?php } ?>

            <?php
            // $check_feedback = $this->crud_model->get_module_function_for_role('feedback', 'all');
            // if ($check_feedback == true) {
            ?>
            <!--<li class="<?php echo isset($feedback)?'active':'' ?>">-->
            <!--    <a href="<?php echo base_url('feedback/admin/all'); ?>">-->
            <!--        <i class="fa fa-th"></i> <span>Feedback</span>-->
            <!--    </a>-->
            <!--</li>-->
            <?php //} ?>
            
             <li class="header">Document</li>
            <?php
            $check_download = $this->crud_model->get_module_for_role('download');
                
            if ($check_download == true) {
            ?>
            <li class="treeview <?php echo isset($download)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-download"></i> <span>Downloads</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_download_cat_all = $this->crud_model->get_module_function_for_role('download_category', 'all');
                    if ($check_download_cat_all == true) {
                    ?>
                    <li class="<?php echo isset($download)? ($download == 'download-category' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('download_category/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            Download Category</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_download_all = $this->crud_model->get_module_function_for_role('download', 'all');
                    if ($check_download_all == true) {
                    ?>
                    <li class="<?php echo isset($download)? ($download == 'download-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('download/admin/all'); ?>"><i class="fa fa-circle-o"></i>List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_download_form = $this->crud_model->get_module_function_for_role('download', 'form');
                    if ($check_download_form == true) {
                    ?>
                    <li class="<?php echo isset($download)? ($download == 'download-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('download/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php } 
            ?>
            
            <?php
            $check_information_office = $this->crud_model->get_module_for_role('information_office');
                
            if ($check_information_office == true) {
            ?>
            <li class="treeview <?php echo isset($information_office)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-tasks"></i> <span>Information Offices</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                  
                    <?php
                    $check_information_office_all = $this->crud_model->get_module_function_for_role('information_office', 'all');
                    if ($check_information_office_all == true) {
                    ?>
                    <li class="<?php echo isset($information_office)? ($information_office == 'information_office-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('information_office/admin/all'); ?>"><i class="fa fa-circle-o"></i>List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_information_office_form = $this->crud_model->get_module_function_for_role('information_office', 'form');
                    if ($check_information_office_form == true) {
                    ?>
                    <li class="<?php echo isset($information_office)? ($information_office == 'information_office-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('information_office/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php } 
            ?>
            
             <?php
            $check_learning_dev = $this->crud_model->get_module_for_role('learning_dev');
                
            if ($check_learning_dev == true) {
            ?>
            <li class="treeview <?php echo isset($learning_dev)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-graduation-cap"></i> <span>Learning & Development</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                  
                    <?php
                    $check_learning_dev_all = $this->crud_model->get_module_function_for_role('learning_dev', 'all');
                    if ($check_learning_dev_all == true) {
                    ?>
                    <li class="<?php echo isset($learning_dev)? ($learning_dev == 'learning_dev-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('learning_dev/admin/all'); ?>"><i class="fa fa-circle-o"></i>List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_learning_dev_form = $this->crud_model->get_module_function_for_role('learning_dev', 'form');
                    if ($check_learning_dev_form == true) {
                    ?>
                    <li class="<?php echo isset($learning_dev)? ($learning_dev == 'learning_dev-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('learning_dev/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php } 
            ?>

            <?php
            $check_report = $this->crud_model->get_module_for_role('report');
            if ($check_report == true) {
            ?>
            <li class="treeview <?php echo isset($report)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-bullhorn"></i> <span>Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_report_cat_all = $this->crud_model->get_module_function_for_role('report_category', 'all');
                    if ($check_report_cat_all == true) {
                    ?>
                    <li class="<?php echo isset($report)? ($report == 'report-category' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('report_category/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            Report Category</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_report_all = $this->crud_model->get_module_function_for_role('report', 'all');
                    if ($check_report_all == true) {
                    ?>
                    <li class="<?php echo isset($report)? ($report == 'report-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('report/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php }  ?>
                    <?php
                    $check_report_form = $this->crud_model->get_module_function_for_role('report', 'form');
                    if ($check_report_form == true) {
                    ?>
                    <li class="<?php echo isset($report)? ($report == 'report-form' ? 'active' :''): ''; ?>">
                        <a href=" <?php echo base_url('report/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php }  ?>
            <li class="header">Interest Rate</li>
             <?php
                $check_fiscal_year = $this->crud_model->get_module_for_role('fiscal_year');
                if ($check_fiscal_year == true) {
                ?>
            <li class="treeview <?php echo isset($fiscal_year)?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Fiscal Year</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_fiscal_year_all = $this->crud_model->get_module_function_for_role('fiscal_year', 'all');
                    if ($check_fiscal_year_all == true) {
                    ?>
                    <li
                        class="<?php echo isset($fiscal_year)? ($fiscal_year == 'fiscal_year-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('fiscal_year/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_fiscal_year_form = $this->crud_model->get_module_function_for_role('fiscal_year', 'form');
                    if ($check_fiscal_year_form == true) {
                    ?>
                    <li
                        class="<?php echo isset($fiscal_year)? ($fiscal_year == 'fiscal_year-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('fiscal_year/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>

            <?php } ?>
             <?php 
            $check_loan = $this->crud_model->get_module_for_role('loan');
            if ($check_loan == true) {
            ?>
            <li class="treeview <?php echo isset($loan)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-info"></i> <span>Loan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                   
                    <?php 
                    $check_loan_all = $this->crud_model->get_module_function_for_role('loan', 'all');
                    if ($check_loan_all == true) {
                    ?>
                    <li class="<?php echo isset($loan)? ($loan == 'loan-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('loan/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php }  ?>
                    <?php 
                    $check_loan_form = $this->crud_model->get_module_function_for_role('loan', 'form');
                    if ($check_loan_form == true) {
                    ?>
                    <li class="<?php echo isset($loan)? ($loan == 'loan-form' ? 'active' :''): ''; ?>">
                        <a href=" <?php echo base_url('loan/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php }  ?>
            <?php 
            $check_deposit = $this->crud_model->get_module_for_role('deposit');
            if ($check_deposit == true) {
            ?>
            <li class="treeview <?php echo isset($deposit)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-info"></i> <span>Deposit</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                  
                    <?php 
                    $check_deposit_all = $this->crud_model->get_module_function_for_role('deposit', 'all');
                    if ($check_deposit_all == true) {
                    ?>
                    <li class="<?php echo isset($deposit)? ($deposit == 'deposit-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('deposit/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php }  ?>
                    <?php 
                    $check_deposit_form = $this->crud_model->get_module_function_for_role('deposit', 'form');
                    if ($check_deposit_form == true) {
                    ?>
                    <li class="<?php echo isset($deposit)? ($deposit == 'deposit-form' ? 'active' :''): ''; ?>">
                        <a href=" <?php echo base_url('deposit/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php }  ?>
             <?php 
            $check_rates = $this->crud_model->get_module_for_role('rates');
            if ($check_rates == true) {
            ?>
            <li class="treeview <?php echo isset($rates)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-percent"></i> <span>Rates</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_rates_cat_all = $this->crud_model->get_module_function_for_role('rates_category', 'all');
                    if ($check_rates_cat_all == true) {
                    ?>
                    <li class="<?php echo isset($rates)? ($rates == 'rates-category' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('rates_category/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            Rates Category</a>
                    </li>
                    <?php } ?>
                    <?php 
                    $check_rates_all = $this->crud_model->get_module_function_for_role('rates', 'all');
                    if ($check_rates_all == true) {
                    ?>
                    <li class="<?php echo isset($rates)? ($rates == 'rates-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('rates/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php }  ?>
                    <?php 
                    $check_rates_form = $this->crud_model->get_module_function_for_role('rates', 'form');
                    if ($check_rates_form == true) {
                    ?>
                    <li class="<?php echo isset($rates)? ($rates == 'rates-form' ? 'active' :''): ''; ?>">
                        <a href=" <?php echo base_url('rates/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php }  ?>
                </ul>
            </li>
            <?php }  ?>
           
            
            
            <?php
            $check_interest_rate_fiscal_year_wise = $this->crud_model->get_module_for_role('interest_rate_fiscal_year_wise');
            if ($check_interest_rate_fiscal_year_wise == true) {
            ?>
            <li class="treeview <?php echo isset($interest_rate_fiscal_year_wise)?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-line-chart"></i> <span>Base Rate & Spread Rate</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_interest_rate_fiscal_year_wise_all = $this->crud_model->get_module_function_for_role('interest_rate_fiscal_year_wise', 'all');
                    if ($check_interest_rate_fiscal_year_wise_all == true) {
                    ?>
                    <li
                        class="<?php echo isset($interest_rate_fiscal_year_wise)? ($interest_rate_fiscal_year_wise == 'interest_rate_fiscal_year_wise-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('interest_rate_fiscal_year_wise/admin/all'); ?>"><i
                                class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_interest_rate_fiscal_year_wise_form = $this->crud_model->get_module_function_for_role('interest_rate_fiscal_year_wise', 'form');
                    if ($check_interest_rate_fiscal_year_wise_form == true) {
                    ?>
                    <li
                        class="<?php echo isset($interest_rate_fiscal_year_wise)? ($interest_rate_fiscal_year_wise == 'interest_rate_fiscal_year_wise-form' ? 'active' :''): ''; ?>">
                        <a href=" <?php echo base_url('interest_rate_fiscal_year_wise/admin/form'); ?>"><i
                                class="fa fa-circle-o"></i> Add New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>

            <?php } ?>

            <?php
            // $check_interest_rate = $this->crud_model->get_module_for_role('interest_rate');
            // if ($check_interest_rate == true) {
            ?>
            <li class="treeview <?php echo isset($interest_rate)? 'active' : ''; ?>">
                <!--<a href="#">-->
                <!--    <i class="fa fa-info-circle"></i> <span>Interest Rate</span>-->
                <!--    <span class="pull-right-container">-->
                <!--        <i class="fa fa-angle-left pull-right"></i>-->
                <!--    </span>-->
                <!--</a>-->
                <!--<ul class="treeview-menu">-->
                    <?php
                    // $check_interest_rate = $this->crud_model->get_module_function_for_role('interest_rate', 'all');
                    // if ($check_interest_rate == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($interest_rate)? ($interest_rate == 'interest_rate-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('interest_rate/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_interest_rate = $this->crud_model->get_module_function_for_role('interest_rate', 'form');
                    // if ($check_interest_rate == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($interest_rate)? ($interest_rate == 'interest_rate-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('interest_rate/admin/form'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Add-->
                    <!--        New</a>-->
                    <!--</li>-->

                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->
            <?php //} ?>

            <?php
            // $check_other_interest_rate = $this->crud_model->get_module_for_role('other_interest_rate');
            // if ($check_other_interest_rate == true) {
            ?>
            <!--<li class="treeview <?php echo isset($other_interest_rate)?  'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-info-circle"></i> <span>Other Interest Rate</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_other_interest_rate = $this->crud_model->get_module_function_for_role('other_interest_rate', 'all');
                    // if ($check_other_interest_rate == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($other_interest_rate)? ($other_interest_rate == 'other_interest_rate-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('other_interest_rate/admin/all'); ?>"><i-->
                    <!--            class="fa fa-circle-o"></i> List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_other_interest_rate = $this->crud_model->get_module_function_for_role('other_interest_rate', 'form');
                    // if ($check_other_interest_rate == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($other_interest_rate)? ($other_interest_rate == 'other_interest_rate-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('other_interest_rate/admin/form'); ?>"><i-->
                    <!--            class="fa fa-circle-o"></i> Add New</a>-->
                    <!--</li>-->

                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->
            <?php //} ?>
            <!--<li class="header">Products</li>-->
            <?php
            // $check_products = $this->crud_model->get_module_for_role('product');
            // if ($check_products == true) {
            ?>
            <!--<li class="treeview <?php echo isset($product)? 'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-pie-chart"></i>-->
            <!--        <span>Product</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_product_cat_all = $this->crud_model->get_module_function_for_role('product_category', 'all');
                    // if ($check_product_cat_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($product)? ($product == 'product-category' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('product_category/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Product Category</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_products_all = $this->crud_model->get_module_function_for_role('product', 'all');
                    // if ($check_products_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($product)? ($product == 'product-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href=" <?php echo base_url('product/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_offer_form = $this->crud_model->get_module_function_for_role('offer', 'form');
                    // if ($check_offer_form == true) {
                    ?>
                    <!--<li class="<?php echo isset($product)? ($product == 'product-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('product/admin/form'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Add New</a>-->
                    <!--</li>-->

                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->

            <?php //} ?>
            <li class="header">Networks</li>
            <?php
            $check_branch = $this->crud_model->get_module_for_role('branch');
            if ($check_branch == true) {
            ?>

            <li class="treeview <?php echo isset($branch)?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-sitemap"></i> <span>Branch</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_branch_all = $this->crud_model->get_module_function_for_role('branch', 'all');
                    if ($check_branch_all == true) {
                    ?>
                    <li class="<?php echo isset($branch)? ($branch == 'branch-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('branch/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_branch_form = $this->crud_model->get_module_function_for_role('branch', 'form');
                    if ($check_branch_form == true) {
                    ?>
                    <li class="<?php echo isset($branch)? ($branch == 'branch-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('branch/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
             <?php
                $check_atm_locations = $this->crud_model->get_module_for_role('atm_locations');
                if ($check_atm_locations == true) {
                ?>
            <li class="treeview <?php echo isset($atm)?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-map-marker"></i> <span>Atm Locations</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_atm_locations_all = $this->crud_model->get_module_function_for_role('atm_locations', 'all');
                    if ($check_atm_locations_all == true) {
                    ?>
                    <li class="<?php echo isset($atm)? ($atm == 'atm-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('atm_locations/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_atm_locations_form = $this->crud_model->get_module_function_for_role('atm_locations', 'form');
                    if ($check_atm_locations_form == true) {
                    ?>
                    <li class="<?php echo isset($atm)? ($atm == 'atm-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('atm_locations/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>


                    <?php } ?>
                </ul>
            </li>

            <?php } ?>
            <li class="header">Organization</li>

            <?php
                $check_designation = $this->crud_model->get_module_for_role('designation');
                if ($check_designation == true) {
                ?>
            <li class="treeview <?php echo isset($designation)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Designation</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_designation_all = $this->crud_model->get_module_function_for_role('designation', 'all');
                    if ($check_designation_all == true) {
                    ?>
                    <li
                        class="<?php echo isset($designation)? ($designation == 'designation-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('designation/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_designation_form = $this->crud_model->get_module_function_for_role('designation', 'form');
                    if ($check_designation_form == true) {
                    ?>
                    <li
                        class="<?php echo isset($designation)? ($designation == 'designation-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('designation/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>

            <?php } ?>




            <?php
                $check_department = $this->crud_model->get_module_for_role('department');
                if ($check_department == true) {
                ?>
            <li class="treeview <?php echo isset($department)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Department</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_department_all = $this->crud_model->get_module_function_for_role('department', 'all');
                    if ($check_department_all == true) {
                    ?>
                    <li class="<?php echo isset($department)? ($department == 'department-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('department/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_department_form = $this->crud_model->get_module_function_for_role('department', 'form');
                    if ($check_department_form == true) {
                    ?>
                    <li
                        class="<?php echo isset($department)? ($department == 'department-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('department/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php
                $check_province = $this->crud_model->get_module_for_role('province');
                if ($check_province == true) {
                ?>
            <li class="treeview <?php echo isset($province)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Province</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_province_all = $this->crud_model->get_module_function_for_role('province', 'all');
                    if ($check_province_all == true) {
                    ?>
                    <li class="<?php echo isset($province)? ($province == 'province-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('province/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_province_form = $this->crud_model->get_module_function_for_role('province', 'form');
                    if ($check_province_form == true) {
                    ?>
                    <li class="<?php echo isset($province)? ($province == 'province-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('province/admin/form'); ?>"><i class="fa fa-circle-o"></i>
                            Add New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>


            <?php } ?>

            <?php
                $check_district = $this->crud_model->get_module_for_role('district');
                if ($check_district == true) {
                ?>
            <li class="treeview <?php echo isset($district)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>District</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_district_all = $this->crud_model->get_module_function_for_role('district', 'all');
                    if ($check_district_all == true) {
                    ?>
                    <li class="<?php echo isset($district)? ($district == 'district-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('district/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_district_form = $this->crud_model->get_module_function_for_role('district', 'form');
                    if ($check_district_form == true) {
                    ?>
                    <li class="<?php echo isset($district)? ($district == 'district-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('district/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            <?php
                $check_municipality = $this->crud_model->get_module_for_role('municipality');
                if ($check_municipality == true) {
                ?>
            <li class="treeview <?php echo isset($municipality)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Municipality</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_municipality_all = $this->crud_model->get_module_function_for_role('municipality', 'all');
                    if ($check_municipality_all == true) {
                    ?>
                    <li class="<?php echo isset($municipality)? ($municipality == 'municipality-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('municipality/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_municipality_form = $this->crud_model->get_module_function_for_role('municipality', 'form');
                    if ($check_municipality_form == true) {
                    ?>
                    <li class="<?php echo isset($municipality)? ($municipality == 'municipality-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('municipality/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add
                            New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

          

            <?php
                $check_count = $this->crud_model->get_module_for_role('count');
                if ($check_count == true) {
                ?>

            <li class="treeview <?php echo isset($count)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa  fa-fast-forward"></i> <span>Counts</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_count_all = $this->crud_model->get_module_function_for_role('count', 'all');
                    if ($check_count_all == true) {
                    ?>
                    <li class="<?php echo isset($count)? ($count == 'count-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('count/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_count_form = $this->crud_model->get_module_function_for_role('count', 'form');
                    if ($check_count_form == true) {
                    ?>
                    <li class="<?php echo isset($count)? ($count == 'count-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('count/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>


            <?php } ?>
            <li class="header">User Management</li>
            <?php
                $check_user_role = $this->crud_model->get_module_for_role('user_role');
                if ($check_user_role == true) {
                ?>
            <li class="treeview <?php echo isset($user_role)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-user-secret"></i>
                    <span>Role</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                      $check_user_role_all = $this->crud_model->get_module_function_for_role('user_role', 'all');
                      if ($check_user_role_all == true) {
                      ?>
                    <li class="<?php echo isset($user_role)? ($user_role == 'user_role-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('user_role/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                      $check_user_role_form = $this->crud_model->get_module_function_for_role('user_role', 'form');
                      if ($check_user_role_form == true) {
                      ?>
                    <li class="<?php echo isset($user_role)? ($user_role == 'user_role-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('user_role/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php
                $check_module = $this->crud_model->get_module_for_role('module');
                if ($check_module == true) {
                ?>

            <li class="treeview <?php echo isset($modules)?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-universal-access"></i>
                    <span>Permission</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                      $check_module_all = $this->crud_model->get_module_function_for_role('module', 'all');
                      if ($check_module_all == true) {
                      ?>
                    <li class="<?php echo isset($modules)? ($modules == 'modules-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('module/admin/all'); ?>"><i class="fa fa-circle-o"></i> Modules</a>
                    </li>
                    <?php } ?><?php
                      $check_user_role_form = $this->crud_model->get_module_function_for_role('user_role', 'form');
                      if ($check_user_role_form == true) {
                      ?>
                    <li class="<?php echo isset($modules)? ($modules == 'modules-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('module/admin/form'); ?>"><i class="fa fa-circle-o"></i> Modules
                            Add</a>
                    </li>
                    <?php } ?>
                    <?php
                        $check_module_role_function = $this->crud_model->get_module_function_for_role('module', 'role_function');
                        if ($check_module_role_function == true) {
                        ?>
                    <li
                        class="<?php echo isset($modules)? ($modules == 'modules-role_function' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('module/admin/role_function'); ?>"><i class="fa fa-circle-o"></i>
                            Role Permission</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>


            <?php } ?>
            <?php
                $check_user = $this->crud_model->get_module_for_role('user');
                if ($check_user == true) {
                ?>
                
            

            <li class="treeview <?php echo isset($users)?'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-user-plus"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                      $check_user_all = $this->crud_model->get_module_function_for_role('user', 'all');
                      if ($check_user_all == true) {
                      ?>
                    <li class="<?php echo isset($users)? ($users == 'users-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('user/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php } ?>
                    <?php
                      $check_user_form = $this->crud_model->get_module_function_for_role('user', 'form');
                      if ($check_user_form == true) {
                      ?>
                    <li class="<?php echo isset($users)? ($users == 'users-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('user/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>

            <?php } ?>
            <?php
            $check_staff = $this->crud_model->get_module_for_role('staff');
            if ($check_staff == true) {
            ?>
            <li class="treeview <?php echo isset($staff)? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                    $check_staff_all = $this->crud_model->get_module_function_for_role('staff', 'all');
                    if ($check_staff_all == true) {
                    ?>
                    <li class="<?php echo isset($staff)? ($staff == 'staff-all' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('staff/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>

                    <?php } ?>
                    <?php
                    $check_staff_form = $this->crud_model->get_module_function_for_role('staff', 'form');
                    if ($check_staff_form == true) {
                    ?>
                    <li class="<?php echo isset($staff)? ($staff == 'staff-form' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('staff/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>
                    </li>
                    <?php } ?>
                    <?php
                    $check_staff_dep_deg_all = $this->crud_model->get_module_function_for_role('staff_dep_deg', 'all');
                    if ($check_staff_dep_deg_all == true) {
                    ?>
                    <li class="<?php echo isset($staff)? ($staff == 'staff_dep_deg' ? 'active' :''): ''; ?>">
                        <a href="<?php echo base_url('staff_dep_deg/admin/all'); ?>"><i class="fa fa-circle-o"></i>
                            Staff Desig/depart</a>
                    </li>

                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            

            <li class="header">Settings</li>
            <?php
                $check_site_settings = $this->crud_model->get_module_for_role('site_settings');
                if ($check_site_settings == true) {
                ?>
            <li class="<?php echo isset($setting)? 'active' : ''; ?>">
                <a href="<?php echo base_url('site_settings/admin'); ?>">
                    <i class="fa fa-cog fa-spin"></i> <span>Site Setting</span>
                </a>
            </li>
            <?php 
                } ?>
             <?php
            // $check_blogs = $this->crud_model->get_module_for_role('blog');
            // if ($check_blogs == true) {
            ?>
            <!--<li class="treeview <?php echo isset($blog)? 'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-edit"></i> <span>Blog</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_blog_cat_all = $this->crud_model->get_module_function_for_role('blog_category', 'all');
                    // if ($check_blog_cat_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($blog)? ($blog == 'blog-category' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('blog_category/admin/all'); ?>"><i class="fa fa-circle-o"></i> Blog-->
                    <!--        Category</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_blogs_all = $this->crud_model->get_module_function_for_role('blog', 'all');
                    // if ($check_blogs_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($blog)? ($blog == 'blog-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('blog/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_blog_form = $this->crud_model->get_module_function_for_role('blog', 'form');
                    // if ($check_blog_form == true) {
                    ?>
                    <!--<li class="<?php echo isset($blog)? ($blog == 'blog-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('blog/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add New</a>-->
                    <!--</li>-->

                    <?php //} 
            //             $check_advertisement = $this->crud_model->get_module_function_for_role('advertisement', 'all');
            // if ($check_advertisement == true) {
            // ?>
            <!--<li class="<?php echo isset($advertisement)? 'active' : ''; ?>">-->
            <!--    <a href="<?php echo base_url('advertisement/admin/all'); ?>">-->
            <!--        <i class="fa fa-th"></i> <span>Advertisement</span>-->
            <!--    </a>-->
            <!--</li>-->
            <?php 
                //} ?>
            <!--    </ul>-->
            <!--</li>-->
            <?php //} ?>
            
              <?php
                // $check_testimonials = $this->crud_model->get_module_for_role('testimonials');
                // if ($check_testimonials == true) {
                ?>
            <!--<li class="treeview <?php echo isset($testimonial)? 'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-feed"></i> <span>Testimonials</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_testimonials_all = $this->crud_model->get_module_function_for_role('testimonials', 'all');
                    // if ($check_testimonials_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($testimonial)? ($testimonial == 'testimonial-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('testimonials/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_testimonials_form = $this->crud_model->get_module_function_for_role('testimonials', 'form');
                    // if ($check_testimonials_form == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($testimonial)? ($testimonial == 'testimonial-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('testimonials/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add-->
                    <!--        New</a>-->
                    <!--</li>-->
                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->

            <?php //} ?>

        <!--</ul>-->
          <!--<li class="header">Organization</li>-->
            <?php
                // $check_closing_days = $this->crud_model->get_module_for_role('closing_days');
                
                // if ($check_closing_days == true) {
                ?>
            <!--<li class="treeview <?php echo isset($closing_days)?  'active' :''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-calendar"></i> <span>Closing Days</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_closing_days_all = $this->crud_model->get_module_function_for_role('closing_days', 'all');
                    // if ($check_closing_days_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($closing_days)? ($closing_days == 'closing_days-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('closing_days/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_closing_days_form = $this->crud_model->get_module_function_for_role('closing_days', 'form');
                    // if ($check_closing_days_form == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($closing_days)? ($closing_days == 'closing_days-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('closing_days/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add-->
                    <!--        New</a>-->
                    <!--</li>-->
                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->

            <?php //} ?>

            <?php
                // $check_calendar_year = $this->crud_model->get_module_for_role('calendar_year');
                // if ($check_calendar_year == true) {
                ?>

            <!--<li class="treeview <?php echo isset($calendar_year)?  'active': ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-calendar"></i> <span>Calendar Year</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_calendar_year_all = $this->crud_model->get_module_function_for_role('calendar_year', 'all');
                    // if ($check_calendar_year_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($calendar_year)? ($calendar_year == 'calendar_year-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('calendar_year/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->


                    <?php //} ?>
                    <?php
                    // $check_calendar_year_form = $this->crud_model->get_module_function_for_role('calendar_year', 'form');
                    // if ($check_calendar_year_form == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($calendar_year)? ($calendar_year == 'calendar_year-form' ? 'active' :'') : ''; ?>">-->
                    <!--    <a href="<?php echo base_url('calendar_year/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add-->
                    <!--        New</a>-->
                    <!--</li>-->

                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->


            <?php //} ?>

            <?php
                // $check_calendar = $this->crud_model->get_module_for_role('calendar');
                // if ($check_calendar == true) {
                ?>
            <!--<li class="treeview <?php echo isset($calendar)?'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-calendar"></i> <span>Calendar</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_calendar_all = $this->crud_model->get_module_function_for_role('calendar', 'all');
                    // if ($check_calendar_all == true) {
                    ?>
                    <!--<li class="<?php echo isset($calendar)? ($calendar == 'calendar-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('calendar/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        List</a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_calendar_form = $this->crud_model->get_module_function_for_role('calendar', 'form');
                    // if ($check_calendar_form == true) {
                    ?>
                    <!--<li class="<?php echo isset($calendar)? ($calendar == 'calendar-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('calendar/admin/form'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Add New</a>-->
                    <!--</li>-->
                    <?php //} ?>
            <!--    </ul>-->
            <!--</li>-->


            <?php //} ?>
            
            <?php
            // $check_extension_counter = $this->crud_model->get_module_for_role('extension_counter');
            // if ($check_extension_counter == true)
            // {
            ?>
            
                <!--<li class="treeview <?php echo isset($extension_counter) ?  'active' : ''; ?>">-->
                <!--    <a href="#">-->
                <!--        <i class="fa fa-tree"></i> <span>Extension Counter</span>-->
                <!--        <span class="pull-right-container">-->
                <!--            <i class="fa fa-angle-left pull-right"></i>-->
                <!--        </span>-->
                <!--    </a>-->
                <!--    <ul class="treeview-menu">-->
                        <?php
                        // $check_extension_counter_all = $this->crud_model->get_module_function_for_role('extension_counter', 'all');
                        // if ($check_extension_counter_all == true)
                        {
                        ?>
                            <!--<li class="<?php echo isset($extension_counter) ? ($extension_counter == 'extension_counter-all' ? 'active' : '') : ''; ?>">-->
                            <!--    <a href="<?php echo base_url('extension_counter/admin/all'); ?>"><i class="fa fa-circle-o"></i> List</a>-->
                            <!--</li>-->
                        <?php //} ?>
                        <?php
                        // $check_extension_counter_form = $this->crud_model->get_module_function_for_role('extension_counter', 'form');
                        // if ($check_extension_counter_form == true)
                        // {
                        ?>
                            <!--<li class="<?php echo isset($extension_counter) ? ($extension_counter == 'extension_counter-form' ? 'active' : '') : ''; ?>">-->
                            <!--    <a href="<?php echo base_url('extension_counter/admin/form'); ?>"><i class="fa fa-circle-o"></i> Add-->
                            <!--        New</a>-->
                            <!--</li>-->
                        <?php //} ?>
                <!--    </ul>-->
                <!--</li>-->
            <?php //} ?>

            <?php
                // $check_member_network = $this->crud_model->get_module_for_role('member_network');
                // if ($check_member_network == true) {
                ?>
            <!--<li class="treeview <?php echo isset($member_network)?  'active' : ''; ?>">-->
            <!--    <a href="#">-->
            <!--        <i class="fa fa-street-view"></i> <span>Member Network</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
                    <?php
                    // $check_member_network_category_all = $this->crud_model->get_module_function_for_role('member_network_category', 'all');
                    // if ($check_member_network_category_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($member_network)? ($member_network == 'member_network-category' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('member_network_category/admin/all'); ?>"><i-->
                    <!--            class="fa fa-circle-o"></i> Category Network</a>-->
                    <!--</li>-->

                    <?php //} ?>

                    <?php
                    // $check_member_network_all = $this->crud_model->get_module_function_for_role('member_network', 'all');
                    // if ($check_member_network_all == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($member_network)? ($member_network == 'member_network-all' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('member_network/admin/all'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Member List </a>-->
                    <!--</li>-->

                    <?php //} ?>
                    <?php
                    // $check_member_network_form = $this->crud_model->get_module_function_for_role('member_network', 'form');
                    // if ($check_member_network_form == true) {
                    ?>
                    <!--<li-->
                    <!--    class="<?php echo isset($member_network)? ($member_network == 'member_network-form' ? 'active' :''): ''; ?>">-->
                    <!--    <a href="<?php echo base_url('member_network/admin/form'); ?>"><i class="fa fa-circle-o"></i>-->
                    <!--        Add New</a>-->
                    <!--</li>-->
                    <?php //} ?>
                </ul>
            </li>


            <?php } ?>
    </section>

</aside>