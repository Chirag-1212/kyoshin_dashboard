<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php if ($this->crud_model->get_module_function_for_role('gallery', 'form')): ?>
                            <a href="<?php echo base_url($redirect . 'form'); ?>" class="btn btn-sm btn-primary">add new</a>
                        <?php endif; ?>
                    </h3>
                    <div class="box-tools">
                        <form action="" method="get">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control" placeholder="search" value="<?php echo $this->input->get('table_search'); ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>title</th>
                                <th>image</th>
                                <th>created</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): ?>
                                <?php foreach ($items as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $offset + $key + 1; ?></td>
                                        <td><?php echo $value->title ?></td>
                                        <td><?php echo $value->title_nepali ?></td>
                                        <td>
                                            <?php if ($value->coverimage): ?>
                                                <img src="<?php echo base_url($value->coverimage); ?>" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $value->created ?></td>
                                        <td>
                                            <?php echo ($value->status == '1') ? '<span class="label label-success">active</span>' : '<span class="label label-danger">inactive</span>'; ?>
                                        </td>
                                        <td>
                                            <?php if ($this->crud_model->get_module_function_for_role('gallery', 'form')): ?>
                                                <a href="<?php echo base_url($redirect . 'form/' . $value->id); ?>" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>

                                            <?php if ($this->crud_model->get_module_function_for_role('gallery', 'soft_delete')): ?>
                                                <a data-toggle="modal" data-target="#modal_<?php echo $value->id; ?>" class="btn bg-red btn-flat btn-sm"><i class="fa fa-trash"></i></a>
                                                
                                                <div class="modal fade" id="modal_<?php echo $value->id; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">delete confirmation</h4>
                                                            </div>
                                                            <div class="modal-body">are you sure to delete?</div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">no</button>
                                                                <a href="<?php echo base_url($redirect . 'soft_delete/' . $value->id); ?>" class="btn btn-primary">yes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center">no records found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($items)): ?>
                    <div class="box-footer clearfix">
                        <?php echo $pagination; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>