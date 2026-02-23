<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layouts/admin/partials/head'); ?>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Navbar -->
    <?php $this->load->view('layouts/admin/partials/nav'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php $this->load->view('layouts/admin/partials/aside'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php //echo $site_settings->fav; ?>" alt="<?php //echo $site_settings->site_name; ?>" height="60"
                width="60">
        </div> -->
        <section class="content-header">
            <h1>
                <?php echo $title ?>
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><?php echo $title ?></li>
            </ol>
        </section>

        <section class="content">

            <?php $this->load->view($page); ?>

        </section>

    </div>
    <?php $this->load->view('layouts/admin/partials/customise'); ?>
    <?php $this->load->view('layouts/admin/partials/footer'); ?>

    <div class=" control-sidebar-bg"></div>
    </div>
    <?php echo $this->load->view('layouts/admin/partials/script'); ?>
</body>

</html>