<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php $this->load->view($redirect . '/search'); ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Count List</h3>
                    <div class="box-tools">
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-primary btn-sm">Add New</a>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Count</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($list)): foreach($list as $row): ?>
                        <tr>
                            <td><?php echo ++$offset; ?></td>
                            <td>
                                <strong><?php echo $row->title; ?></strong><br>
                                <small class="text-muted"><?php echo $row->title_jp; ?></small>
                            </td>
                            <td>
                                <?php echo $row->number; ?><br>
                                <small class="text-muted"><?php echo $row->number_jp; ?></small>
                            </td>
                            <td>
                                <?php if($row->status == 1): ?>
                                    <span class="label label-success">active</span>
                                <?php else: ?>
                                    <span class="label label-warning">inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" 
                                   class="btn btn-info btn-xs">edit</a>
                                <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" 
                                   class="btn btn-danger btn-xs" 
                                   onclick="return confirm('are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No Records Found.</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</section>