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
                        <a class="btn btn-sm btn-primary" id="generate_forex">Generate</a>
                        <?php } ?>
                    </h3>
                    <?php include('search.php'); ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Forex Date</th>
                                <th>Publish Date</th>
                                <th>Modified Date</th>
                                <th>Created</th>
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
                                <td><?php echo $value->date_forex; ?></td>
                                <td><?php echo $value->published_on; ?></td>
                                <td><?php echo $value->modified_on; ?></td>
                                <td><?php echo $value->created_on; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                                        $check_view = $this->crud_model->get_module_function_for_role($redirect, $view_check_value);
                                        if ($check_view == true) {
                                        ?>
                                    <a href="<?php echo base_url($view_link . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-eye"></i></a>
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
    </div>
</section>