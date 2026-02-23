<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div>
                        <?php include('search.php'); ?>
                    </div>
                    <h3 class="box-title">
                        <?php
                        $check_designation_form = $this->crud_model->get_module_function_for_role('designation', 'form');
                        if ($check_designation_form == true) {
                        ?>
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-sm btn-primary">Add
                            New</a>
                        <?php } ?>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Designation Code</th>
                                <th>Designation Name</th>
                                <th>Designation Name In Nepali</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                if ($items) {
                  foreach ($items as $key => $value) {
                    if ($value->status == '1') {
                        $status = '<span class="label label-success">Active</span>';
                    } else {
                        $status = '<span class="label label-danger">Inactive</span>';
                    }
                ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->designation_code; ?></td>
                                <td><?php echo $value->designation_name; ?></td>
                                <td><?php echo $value->designation_name_np; ?></td>
                                <td><?php echo $value->remarks; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                        if ($check_designation_form == true) {
                        ?>
                                    <a href="<?php echo base_url($redirect . '/admin/form/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php
                        $check_designation_soft_delete = $this->crud_model->get_module_function_for_role('designation', 'soft_delete');
                        if ($check_designation_soft_delete == true) {
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