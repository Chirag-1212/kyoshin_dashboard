<section class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            
                            <?php
                              $check_form = $this->crud_model->get_module_function_for_role('epayment_partners', 'form');
                              if ($check_form == true) {
                            ?>
                            <a href="<?php echo base_url($redirect.'form'); ?>" class="btn btn-sm btn-primary">Add New</a>
                        <?php } ?>
                        </h3>
                      <div class="box-tools">
                        <form action="" method="get">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right"
                                    value="<?php echo set_value('table_search', $this->input->get('table_search')); ?>"
                                    placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
        
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Title</th>  
                          <th>Image</th>
                          <th>Created</th>
                          <th>Created By</th>
                          <th>Updated</th>
                          <th>Updated By</th>
                          <th>status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                            if(!empty($items)){ 
                                foreach($items as $key => $value){  
                                    if($value->updated_by){ 
                                        $updated_by = $this->db->get_where('users',array('id'=>$value->updated_by))->row()->user_name;
                                    }else{
                                        $updated_by = '';
                                    }
    
                                    if($value->created_by){ 
                                        $created_by = $this->db->get_where('users',array('id'=>$value->created_by))->row()->user_name;
                                    }else{
                                        $created_by = '';
                                    } 
                                    $status = "<span class='label label-danger'>Inactive</span>";
                                    if($value->status == '1'){
                                        $status = "<span class='label label-success'>Active</span>";
                                    }
                        ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $value->title ?></td> 
                            <td><?php if($value->featured_image){ ?><img src="<?php echo base_url().$value->featured_image; ?>" class="img-fluid" style="max-height: 150px;object-fit: contain;"><?php } ?></td> 
                            <td><?php echo (new DateTime($value->created))->format('Y-m-d') ?></td>
                            <td><?php echo $created_by ?></td>
                            <td><?php echo $value->updated ?(new DateTime($value->updated))->format('Y-m-d'):''; ?></td>
                            <td><?php echo $updated_by ?></td>
                            <td><?php echo $status ?></td>
                            <td>
                              <?php 
                                  if ($check_form == true) {
                                ?>
                              <a href="<?php echo base_url($redirect.'form/'.$value->id); ?>" class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a> 
                              <?php } ?>
                              
                              <?php
                                  $check_delete = $this->crud_model->get_module_function_for_role('epayment_partners', 'hard_delete');
                                  if ($check_delete == true) {
                                ?>
                              <a class="btn bg-maroon btn-flat margin" data-toggle="modal" data-target="#exampleModal<?php echo $value->id; ?>"><i class="fa fa-trash-o"></i></a> 
    
                              <div class="modal fade" id="exampleModal<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    Are You Sure To Delete?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <a href="<?php echo base_url($redirect.'hard_delete/'.$value->id); ?>" class="btn btn-primary">Yes</a>
                                    </div>
                                    </div>
                                </div>
                              </div>
                              <?php } ?>
                          </td>
                        </tr> 
                        <?php } ?>
                        
                        <?php }else{ ?>
                            <tr>
                                <td colspan="10" style="text-align:center;">No Records Found</td>
                            </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <!-- /.box-body -->
                    <?php if($items){ ?>
                        <div class="box-footer clearfix">
                            <?php echo $pagination; ?>
                        </div>
                    <?php } ?>    
                    </div> 
                </div> 
            </div> 
        </div>
    </div>
</section>
