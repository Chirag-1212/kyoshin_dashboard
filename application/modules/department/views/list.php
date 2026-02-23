<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php
                        $check_department_form = $this->crud_model->get_module_function_for_role('department', 'form');
                        if ($check_department_form == true) {
                        ?>
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-sm btn-primary">Add
                            New</a>
                        <?php } ?>
                    </h3>
                </div>
                <div>
                    <?php include('search.php'); ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Department Code</th>
                                <th>Department Name</th>
                                 <th>Department Name In Nepali</th>
                                <th>Remarks</th>
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
                                <td><?php echo $value->department_code; ?></td>
                                <td><?php echo $value->department_name; ?></td>
                                <td><?php echo $value->department_name_np; ?></td>
                                <td><?php echo $value->remarks; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                                    if ($check_department_form == true) {
                                    ?>
                                    <a href="<?php echo base_url($redirect . '/admin/form/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php
                                    $check_department_soft_delete = $this->crud_model->get_module_function_for_role('department', 'soft_delete');
                                    if ($check_department_soft_delete == true) {
                                    ?>
                                    <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $value->id); ?>"
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