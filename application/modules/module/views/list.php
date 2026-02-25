<section class="container-fluid">
      <h3 class="h3 mb-4 text-gray-800"><?php echo $title ?></h3>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header d-flex justify-content-between align-items-center">
                    <h3 class="box-title">
                        <?php
                        $check_module_form = $this->crud_model->get_module_function_for_role('module', 'form');
                        if ($check_module_form) { ?>
                            <a href="<?= base_url($redirect . '/admin/form'); ?>" class="btn btn-info btn-icon-split mb-4">
                                <span class="icon text-white-600">
                                <i class="fas fa-plus-circle"></i>
                                </span>
                               <span class="text">Add New</span>
                            </a>
                        <?php } ?>
                        <a href="<?= base_url($redirect . '/admin/role_function'); ?>" class="btn btn-info btn-icon-split mb-4">
                           <span class="icon text-white-600">
                                <i class="fas fa-lock"></i>
                            </span>
                            <span class="text">Assign Permission</span> 
                        </a>
                    </h3>

                   
                </div>
                <!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover" style="background-color: #ffffff;">
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

                                    $status = ($value->status == '1') 
                                        ? '<span class="badge badge-success">Active</span>' 
                                        : '<span class="badge badge-danger">Inactive</span>';

                                    $childs = $this->crud_model->get_where('module_function', ['module_id' => $value->id]);
                            ?>
                            <tr>
                                <td><?= $offset; ?></td>
                                <td><?= $value->display_name; ?> (<?= $value->module_name; ?>)</td>
                                <td>
                                    <?php
                                    if ($childs) {
                                        foreach ($childs as $val_c) {
                                            echo $val_c->function_name . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= $status; ?></td>
                                <td>
                                    <?php if ($check_module_form) { ?>
                                        <a href="<?= base_url($redirect . '/admin/form/' . $value->id); ?>" 
                                           class="btn btn-primary btn-sm" title="Edit">
                                          <i class="fa fa-edit"></i>
                                        </a>
                                    <?php } ?>
                                    <?php
                                    $check_module_soft_delete = $this->crud_model->get_module_function_for_role('module', 'soft_delete');
                                    if ($check_module_soft_delete) { ?>
                                        <a href="<?= base_url($redirect . '/admin/soft_delete/' . $value->id); ?>" 
                                           class="btn btn-danger btn-sm" title="Delete">
                                           <i class="fa fa-trash"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $i++; } 
                            } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->

                <?php if ($items) { ?>
                <div class="box-footer clearfix">
                    <?= $pagination; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
