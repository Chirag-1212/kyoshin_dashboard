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
                    <div class="card-footer clearfix"> 
                        <?php echo $pagination; ?>
                    </div>
                <?php } ?>    
              </div> 
            </div> 
          </div> 
        </div>
      </div>
</section>
