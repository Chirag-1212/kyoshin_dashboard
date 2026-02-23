<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php
                            $check_module_form = $this->crud_model->get_module_function_for_role('module', 'form');
                            if ($check_module_form == true) {
                            ?>
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-sm btn-primary">Add
                            New</a>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Module Name</th>
                                <th>Functions</th>
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
                                $childs = $this->crud_model->get_where('module_function', array('module_id' => $value->id));
                            ?>
                            <tr>
                                <td><?php echo $offset; ?></td>
                                <td><?php echo $value->display_name; ?>( <?php echo $value->module_name; ?> )</td>
                                <td>
                                    <?php if (isset($childs)) {
                          foreach ($childs as $key_c => $val_c) {
                            echo $val_c->function_name . '<br>';
                          }
                        } ?>
                                </td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php
                        if ($check_module_form == true) {
                        ?>
                                    <a href="<?php echo base_url($redirect . '/admin/form/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php
                        $check_module_soft_delete = $this->crud_model->get_module_function_for_role('module', 'soft_delete');
                        if ($check_module_soft_delete == true) {
                        ?>
                                    <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $value->id); ?>"
                                        class="btn bg-red btn-flat margin"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }
                } else { ?>

                            <tr>
                                <td colspan="3" style="text-align:center;">No Records Found</td>
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