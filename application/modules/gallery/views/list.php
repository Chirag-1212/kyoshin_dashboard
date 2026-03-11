<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-sm btn-primary">add new</a>
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
                            <th style="width: 50px;">sn</th>
                            <th>title(en)</th>
                            <th>title(jp)</th> <th>image</th>
                            <th>created</th>
                            <th>status</th>
                            <th style="width: 100px;">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $key => $value): ?>
                                <tr>
                                    <td><?php echo $offset + $key + 1; ?></td>
                                    <td><?php echo $value->title_en; ?></td> <td><?php echo $value->title_jn; ?></td> <td>
                                        <?php if (!empty($value->coverimage)): ?>
                                            <img src="<?php echo base_url($value->coverimage); ?>" style="max-height: 50px; border-radius: 4px;">
                                        <?php else: ?>
                                            <span class="text-muted small">no image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $value->created; ?></td>
                                    <td>
                                        <?php echo ($value->status == '1') ? '<span class="label label-success">active</span>' : '<span class="label label-danger">inactive</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url($redirect . '/admin/form/' . $value->id); ?>" class="btn bg-purple btn-flat btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                        
                                        <a data-toggle="modal" data-target="#modal_<?php echo $value->id; ?>" class="btn bg-red btn-flat btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
                                        
                                        <div class="modal fade" id="modal_<?php echo $value->id; ?>" tabindex="-1" role="dialog">
                                            </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
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