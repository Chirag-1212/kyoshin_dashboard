<section class="content">
      <div class="container-fluid"> 
        <form class="all_form" method="post" action enctype="multipart/form-data">    
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><?php echo $title ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div> 
              <div class="card-body">
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Name : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->name)) && $detail->name != '')? $detail->name : '') ?></p> 
                    </div> 
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Email : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->email)) && $detail->email != '')? $detail->email : '') ?></p> 
                    </div> 
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Mobile no. : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->mobno)) && $detail->mobno != '')? $detail->mobno : '') ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Branch : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->branch_name)) && $detail->branch_name != '')? $detail->branch_name : '') ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Attachment file : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url() . '/uploads/grievance/' . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Subject : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->subject)) && $detail->subject != '')? $detail->subject : '') ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Issue : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->issue)) && $detail->issue != '')? $detail->issue : '') ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Date : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                      <p><?php echo (((isset($detail->date)) && $detail->date != '')? $detail->date : '') ?></p> 
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Issue Reply : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                        <p><?php echo (((isset($detail->issue_reply)) && $detail->issue_reply != '')? $detail->issue_reply : '') ?></p>
                    </div> 
                  </div>
                </div>  
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Approved By : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                        <p>
                            <?php 
                                if($detail->approved_by){ 
                                    $updated_by = $this->db->get_where('users',array('id'=>$detail->approved_by))->row()->user_name;
                                }else{
                                    $updated_by = '';
                                }
                                echo $updated_by; 
                            ?>
                        </p>
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>User Code : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                        <p><?php echo (((isset($detail->user_code)) && $detail->user_code != '')? $detail->user_code : '') ?></p>
                    </div> 
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Status : </label> 
                    </div> 
                  </div>
                  <div class="col-md-5">
                    <div class="form-group"> 
                        <p>
                            <?php
                                if($detail->status == '1'){
                                    echo "Approved";
                                }else{
                                    echo "Pending";
                                }
                            ?>
                        </p>
                    </div> 
                  </div>
                </div>  
              </div> 
            </div>  
        </form>
      </div>
</section>
<script>
  function responsive_filemanager_callback(field_id){  
        var url=$('#'+field_id).val();
        // alert('yo'); 
        $('#'+field_id).next().next().attr('src',url);
        $('#'+field_id).next().next().show(); 
  } 
</script>