<!-- Navbar -->
<div class="wrapper">
    <header class="main-header">

        <a target="_blank" href="<?php echo $site_settings->web_url ?>" class="logo">
            <span class="logo-mini"><b><img src="<?php echo base_url().$site_settings->fav ?>" class="img-circle"
                    alt="<?php echo $site_settings->short_name ?>"></b></span>
            <span class="logo-lg"><b><img src="<?php echo base_url().$site_settings->logo ?>" class=""
                    alt="<?php echo $site_settings->short_name ?>"></b></span>
        </a>

        <nav class="navbar navbar-static-top">

            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url().$staff_featured_image; ?>" class="user-image"
                                alt="<?php echo $staff_name; ?>">
                            <span class="hidden-xs"><?php echo $staff_name; ?></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <img src="<?php echo base_url().$staff_featured_image; ?>" class="img-circle"
                                    alt="<?php echo $staff_name; ?>">
                                <p>
                                    <?php echo $staff_name;?>
                                    <small>Member since
                                        <?php echo (new DateTime($appointed_date))->format('M. Y'); ?></small>
                                </p>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo base_url('common/admin/changepasswordown'); ?>"
                                        class="btn btn-default btn-flat <?php if($current_user->psd_changed != '1'){?>red <?php } ?>">Profile</a>
                                </div>

                                <div class=" pull-right" style="margin: 0px 0px 0px 20px;">
                                    <a href="<?php echo base_url('login/logout') ?>"
                                        class="btn btn-default btn-flat">Sign out</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url('site_settings/admin'); ?>"
                                        class="btn btn-default btn-flat">Settings</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li> -->
                </ul>
            </div>
        </nav>
    </header>


    <!-- /.navbar -->