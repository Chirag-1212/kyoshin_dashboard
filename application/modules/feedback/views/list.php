<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        Feedback List
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Message</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                if ($items) {
                                    $i = 1;
                                  foreach ($items as $key => $value) { 
                                    $offset = $offset + $i;
                                    if ($value->status == '1') {
                                        $status = '<span class="label label-success">Active</span>';
                                    } else {
                                        $status = '<span class="label label-danger">Inactive</span>';
                                    }

                                ?>
                            <tr>
                                <td><?php echo $offset; ?></td>
                                <td><?php echo $value->fullname; ?></td>
                                <td><?php echo $value->email; ?></td>
                                <td><?php echo $value->address; ?></td>
                                <td><?php echo $value->phone; ?></td>
                                <td><?php echo $value->message; ?></td>
                                <td><?php echo ($value->created_on != '0000-00-00')?$value->created_on:'-'; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <a href="<?php echo base_url('feedback/admin/view/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-eye"></i></a>
                                    <?php
                        $check_soft_delete = $this->crud_model->get_module_function_for_role($redirect, $delete_check_value);
                        if ($check_soft_delete == true) {
                        ?>
                                    <a href="<?php echo base_url($delete_link . $value->id); ?>"
                                        class="btn bg-red btn-flat margin"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }
                } else { ?>

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