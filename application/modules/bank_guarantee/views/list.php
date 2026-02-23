<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php
                      $check_form = $this->crud_model->get_module_function_for_role('bank_guarantee', 'form');
                      if ($check_form == true) {
                    ?>
                        <a href="<?php echo base_url($redirect.'form'); ?>" class="btn btn-sm btn-primary">Add New</a>

                        <?php } ?>
						<?php
                      $check_import_from_excel = $this->crud_model->get_module_function_for_role('bank_guarantee', 'import_from_excel');
                      if ($check_import_from_excel == true) {
                    ?>
                    <a href="<?php echo base_url($redirect.'import_from_excel'); ?>" class="btn btn-sm btn-primary">Import from CSV</a>
                    </h3>
                    <?php } ?>
                    
                     <?php
                      $check_edit_from_excel = $this->crud_model->get_module_function_for_role('bank_guarantee', 'edit_from_excel');
                      if ($check_edit_from_excel == true) {
                    ?>
                    <a href="<?php echo base_url($redirect.'edit_from_excel'); ?>" class="btn btn-sm btn-primary">Edit from CSV</a>
                    </h3>
                    <?php } ?>
                    </h3>
                    <div>
                        <?php
                        
                        $branches=$branches;
                        $reference_numbers=$reference_numbers;
                     
                        include('search.php');
                        ?>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
							  <th>#</th>
							  <th>Issued Branch</th>  
							  <th>Beneficiary Name</th> 
							  <th>Reference Number</th>
							  <th>Issued Date</th>
							  <th>Value Date</th>
							  <th>Expiry Date</th>
							  <th>Currency Symbol</th>
							  <th>Currency Code</th>
							  <th>Amount</th>
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
                        if($items){ 
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
                                
                                if($value->issued_branch){ 
                                    $issued_branch = $this->db->get_where('branches',array('id'=>$value->issued_branch))->row()->PageTitle;
                                }else{
                                    $issued_branch = '';
                                }
                                
                                if($value->currency_id){ 
                                    $currency_detail = $this->db->get_where('currency',array('id'=>$value->currency_id))->row();
                                    $currency_code = $currency_detail->code;
                                    $currency_symbol = $currency_detail->symbol;
                                }else{
                                    $currency_code = '';
                                    $currency_symbol = '';
                                } 
                              
                                if ($value->status == '1') {
                                    $status = '<span class="label label-success">Active</span>';
                                } else {
                                    $status = '<span class="label label-danger">Inactive</span>';
                                }
                    ?>
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td><?php echo $issued_branch; ?></td> 
								<td><?php echo $value->beneficiary_name ?></td> 
								<td><?php echo $value->reference_number ?></td> 
								<td><?php echo $value->issue_date ?></td> 
								<td><?php echo $value->value_date ?></td> 
								<td><?php echo $value->expiry_date ?></td>
								<td><?php echo $currency_symbol; ?></td>
								<td><?php echo $currency_code ?></td> 
								<td><?php echo $value->amount ?></td> 
								<td><?php echo $value->created_on ?></td>
								<td><?php echo $created_by ?></td>
								<td><?php echo $value->updated_on ?></td>
								<td><?php echo $updated_by ?></td>
								<td><?php echo $status ?></td>
                                <td>
                                    <?php 
                          if ($check_form == true) {
                        ?>
                                    <a href="<?php echo base_url($redirect.'form/'.$value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>

                                    <?php
                              $check_delete = $this->crud_model->get_module_function_for_role('bank_guarantee', 'soft_delete');
                              if ($check_delete == true) {
                            ?>
                                    <a data-toggle="modal" data-target="#exampleModal<?php echo $value->id; ?>"
                                        class="btn bg-red btn-flat margin"><i class="fa fa-trash-o"></i></a>

                                    <div class="modal fade" id="exampleModal<?php echo $value->id; ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are You Sure To Delete?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No</button>
                                                    <a href="<?php echo base_url($redirect.'soft_delete/'.$value->id); ?>"
                                                        class="btn btn-primary">Yes</a>
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
</section>