<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php
                        $check_form = $this->crud_model->get_module_function_for_role($redirect, $form_check_value);
                        if ($check_form == true) {
                        ?>
                        <a href="<?php echo base_url($form_link); ?>" class="btn btn-sm btn-primary">Add New</a>
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
                                <th>#</th>
                                <th>Title</th>
                                <th>Year</th>
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
                                
                                
                                if ($value->calendar_year_id) {
                                  $fiscal_year = $this->db->get_where('calendar_year', array('id' => $value->calendar_year_id))->row();
                                  if (isset($fiscal_year->title)) {
                                    $fiscal_year = $fiscal_year->title;
                                  } else {
                                    $fiscal_year = '';
                                  }
                                } else {
                                  $fiscal_year = '';
                                }
                            ?>
                            <tr>
                                <td><?php echo $offset; ?></td>
                                <td><?php echo $value->Title; ?></td>
                                <td><?php echo $fiscal_year; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                                  if ($check_form == true) {
                                  ?>
                                    <a href="<?php echo base_url($form_link . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
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