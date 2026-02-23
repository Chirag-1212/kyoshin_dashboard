<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php
                  //  echo isset($branch_total->total) ? $branch_total->total:0;
                    ?>
                    </h3>
                    <p>Branches</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tree"></i>
                </div>
                <a href="<?php echo base_url().'branch/admin/all'; ?>" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php //echo isset($atm_total->total) ? $atm_total->total:0; ?></h3>
                    <p>Atm locations</p>
                </div>
                <div class="icon">
                    <i class="fa fa-map-marker"></i>
                </div>
                <a href="<?php echo base_url().'atm_locations/admin/all'; ?>" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php
              //echo isset($total_news->total) ? $total_news->total:0;
              ?></h3>
                    <p>News</p>
                </div>
                <div class="icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php
                    //echo isset($users_total->total) ? $users_total->total:0;
              ?></h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo base_url().'user/admin/all'; ?>" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
         <!--<div class="col-lg-3 col-xs-6">-->

            <!--<div class="small-box bg-orange">-->
            <!--    <div class="inner">-->
            <!--        <h3>--><?php
            //   echo isset($total_video->total) ? $total_video->total:0;
            ?> <!-- </h3>-->
            <!--        <p>Video</p>-->
            <!--    </div>-->
            <!--    <div class="icon">-->
            <!--        <i class="fa fa-video-camera"></i>-->
            <!--    </div>-->
            <!--    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            <!--</div>-->
        <!--</div>-->

    </div>
</section>