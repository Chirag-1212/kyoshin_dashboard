<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php
                        $check_user_form = $this->crud_model->get_module_function_for_role('user', 'form');
                        if ($check_user_form == true) {
                        ?>
                        <a href="<?php echo base_url('user/admin/form'); ?>" class="btn btn-sm btn-primary">Add New</a>
                        <?php } ?>
                    </h3>
                    <div>
                        <?php include('search.php'); ?>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Created</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                if ($items) {
                  foreach ($items as $key => $value) {
                    $staff_detail = $this->crud_model->get_where_single_order_by('staff_infos', array('id' => $value->staff_id), 'id', 'DECS');
                    $staff_depart_desg = $this->crud_model->get_where_single_order_by('staff_desig_depart', array('staff_id' => $value->staff_id, 'status' => '1'), 'id', 'DECS');
                    // echo "<pre>";
                    // var_dump($staff_depart_desg);
                    if ($value->updated_by) {
                      $updated_by = $this->db->get_where('users', array('id' => $value->updated_by))->row()->user_name;
                    } else {
                      $updated_by = '';
                    }

                    if ($value->created_by) {
                      $created_by = $this->db->get_where('users', array('id' => $value->created_by))->row()->user_name;
                    } else {
                      $created_by = '';
                    }

                    if ($value->role_id) {
                      $role = $this->db->get_where('user_role', array('id' => $value->role_id))->row()->name;
                    } else {
                      $role = '';
                    }

                    // if ($staff_detail->country_code) {
                    //   $nationality = $this->db->get_where('country_para', array('country_code' => $staff_detail->country_code))->row()->nationality;
                    // } else {
                    //   $nationality = '';
                    // }

                    if (isset($staff_depart_desg->department_code)) {
                      $depart = $this->db->get_where('department_para', array('department_code' => $staff_depart_desg->department_code))->row();
                      if(isset($depart->department_name)){
                          $depart = $depart->department_name;
                      }else{
                          $depart = '';
                      }
                    } else {
                      $depart = '';
                    }


                    if (isset($staff_depart_desg->designation_code)) {
                      $desig_row = $this->db->get_where('designation_para', array('designation_code' => $staff_depart_desg->designation_code))->row();
                      if(isset($desig_row->designation_name)){
                          $desig = $desig_row->designation_name;
                      }else{
                          $desig = '';
                      }
                    } else {
                      $desig = '';
                    }

                    if ($value->status == '1') {
                        $status = '<span class="label label-success">Active</span>';
                    } else {
                        $status = '<span class="label label-danger">Inactive</span>';
                    }
                ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php if (isset($staff_detail->full_name)) {
                            echo $staff_detail->full_name;
                          } ?></td>
                                <td><?php echo $role ?></td>
                                <!--<td>-->
                                <?php 
                                // if (isset($staff_detail->permanent_address)) {
                                //     echo $staff_detail->permanent_address;
                                //   } 
                                ?>
                                <!--</td>-->
                                <!--<td>-->
                                <?php
                                // if (isset($staff_detail->temp_address)) {
                                //     echo $staff_detail->temp_address;
                                //   } 
                                  ?>
                                <!--</td>-->
                                <td>
                                <?php if (isset($staff_detail->contact)) {
                                    echo $staff_detail->contact;
                                  } ?>
                                </td>
                                <td><?php if (isset($staff_detail->email)) {
                            echo $staff_detail->email;
                          } ?></td>
                               <td><?php if (isset($value->user_name)) {
                                    echo $value->user_name;
                                } ?></td>
                               
                                <td><?php if (isset($staff_detail->appointed_date)) {
                            echo $staff_detail->appointed_date;
                          } ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                        if ($check_user_form == true) {
                        ?>
                                    <a href="<?php echo base_url('user/admin/form/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php
                        $check_user_delete = $this->crud_model->get_module_function_for_role('user', 'soft_delete');
                        if ($check_user_delete == true) {
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
                                                    <a href="<?php echo base_url('user/admin/soft_delete/' . $value->id); ?>"
                                                        class="btn btn-primary">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php
                                    $check_user_password_change = $this->crud_model->get_module_function_for_role('user', 'changepassword');
                                    if ($check_user_password_change == true) {
                                    ?>
                                    <a href="<?php echo base_url('user/admin/changepassword/' . $value->id); ?>"
                                        class="btn btn-sm btn-primary">Password</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php } else { ?>
                            <tr>
                                <td colspan="9" style="text-align:center;">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    <?php if ($items) { ?>
                    <div class="box-footer clearfix">
                        <?php echo $pagination; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>