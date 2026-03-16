<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php $this->load->view($redirect . '/search'); ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Testimonials</h3>
                    <div class="box-tools">
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-primary btn-sm">Add New</a>
                    </div>
                </div>
                
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list)): 
                                foreach($list as $key => $row): 
                                    // Fix: Calculate S.N. based on pagination offset and current loop index
                                    $sn = $offset + $key + 1;
                            ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td> 
                                        <?php if (!empty($row->doc_path)): ?>
                                            <img src="<?php echo base_url($row->doc_path); ?>" alt="image" width="50">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row->title; ?></td>
                                    <td>
                                        <?php if($row->status == 1): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" class="btn btn-info btn-xs">Edit</a>
                                        <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                    <td>
                                        <?php 
                                        $check_form = $this->crud_model->get_module_function_for_role($redirect, $form_check_value);
                                        if ($check_form == true): ?>
                                            <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" 
                                               class="btn bg-purple btn-flat btn-sm" title="edit">
                                               <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php 
                                        $check_soft_delete = $this->crud_model->get_module_function_for_role($redirect, $delete_check_value);
                                        if ($check_soft_delete == true): ?>
                                            <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" 
                                               class="btn bg-red btn-flat btn-sm" title="delete" 
                                               onclick="return confirm('Are you sure?')">
                                               <i class="fa fa-trash-o"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</section>