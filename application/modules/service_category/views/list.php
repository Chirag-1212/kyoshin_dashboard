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
                    <div class="box-tools">
                        <form action="" method="get">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">

                                <input type="text" name="table_search" class="form-control pull-right"
                                    placeholder="Search"
                                    value="<?php echo set_value('table_search', $this->input->get('table_search')); ?>">
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
                                <th>Category</th>
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
                                $status = 'Active';
                                } else {
                                $status = 'Inactive';
                                }
                                if ($value->parent_id > 0) {
                                $parent =  $this->db->get_where('service_category', array('id' => $value->parent_id))->row()->Title;
                                } else {
                                $parent = 'Main Category';
                                }
                            ?>
                            <tr>
                                <td><?php echo $offset; ?></td>
                                <td><?php echo $value->Title; ?></td>
                                <td><?php echo $parent; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                                        if ($check_form == true) {
                                        ?>
                                    <a href="<?php echo base_url($form_link . $value->id); ?>"
                                        class="btn btn-sm btn-primary" style="margin: 5px;">Edit</a>
                                    <?php } ?>
                                    <?php
                                    $check_soft_delete = $this->crud_model->get_module_function_for_role($redirect, $delete_check_value);
                                    if ($check_soft_delete == true) {
                                    ?>
                                    <a href="<?php echo base_url($delete_link . $value->id); ?>"
                                        class="btn btn-sm btn-danger" style="margin: 5px;">Delete</a>
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