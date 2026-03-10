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
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="table_search" class="form-control"
                                    placeholder="Search..."
                                    value="<?php echo htmlspecialchars($this->input->get('table_search') ?? ''); ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title (EN)</th>
                                <th>Title (JP)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list)): ?>
                                <?php foreach ($list as $row): ?>
                                <tr>
                                    <td><?php echo $row->id; ?></td>
                                    <td>
                                        <?php if (!empty($row->docpath)): ?>
                                            <img src="<?php echo base_url($row->docpath); ?>" style="width: 50px;">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo $row->title_en; ?></strong></td>
                                    <td><?php echo $row->title_jp; ?></td>
                                    <td>
                                        <?php if ($row->status == 1): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" 
                                           class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo base_url($redirect . '/admin/delete/' . $row->id); ?>" 
                                           class="btn btn-xs btn-danger" 
                                           onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="box-footer clearfix">
                    <div class="pull-right">
                        <?php echo isset($pagination) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>