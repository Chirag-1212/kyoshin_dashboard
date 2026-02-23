<section class="content">
      <div class="container-fluid">  
      <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div>
                  <?php include('search_logged_users.php'); ?>
                </div>
                <h3 class="card-title">
                    <!--<form action="<?php //echo base_url('bank_guarantee/admin/search_logged_users'); ?> " method="post">-->
                    <!--    <input type="hidden" name="email" class="form-control" placeholder="Email" value="<?php //echo (isset($data_filter['email']) && $data_filter['email'] != '')? $data_filter['email'] : ''  ?>">-->
                    <!--    <input type="hidden" name="reference_number" class="form-control" placeholder="Reference Number" value="<?php //echo (isset($data_filter['reference_number']) && $data_filter['reference_number'] != '')? $data_filter['reference_number'] : ''  ?>">-->
                    <!--    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="pdf" value="Export to pdf" style="width: 100%;">   </div>-->
                    <!--</form>-->
                    <!--<img src="<?php //echo base_url('uploads/primelogo.png'); ?>">-->
                </h3>    
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Email</th>  
                      <th>OTP Code</th> 
                      <th>Reference Number</th>
                      <th>Date/Time</th>   
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        if(!empty($items)){ 
                            foreach($items as $key => $value){    
                    ?>
                    <tr>
                      <td><?php echo $key+1 ?></td>
                      <td><?php echo $value->email; ?></td> 
                      <td><?php echo $value->otp_code; ?></td> 
                      <td><?php echo $value->reference_number; ?></td> 
                      <td><?php echo $value->created_time_stamp; ?></td>   
                    </tr> 
                    <?php } ?>
                    
                    <?php }else{ ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No Records Found</td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <!-- /.card-body -->
                <?php if($items){ ?>
                    <!--<div class="card-footer clearfix"> -->
                    <!--    <?php //echo $pagination; ?>-->
                    <!--</div>-->
                <?php } ?>    
              </div> 
            </div> 
          </div> 
        </div>
      </div>
</section>
