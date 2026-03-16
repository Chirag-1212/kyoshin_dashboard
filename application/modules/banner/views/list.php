<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php $this->load->view($redirect . '/search'); ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Banner List</h3>
                    <div class="box-tools">
                        <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-primary btn-sm">Add New</a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($list)): foreach($list as $row): ?>
                        <tr>
                            <td><?php echo ++$offset; ?></td>
                            <td><?php echo $row->submitdt; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td><code><?php echo $row->slug; ?></code></td>
                            <td><?php echo $row->file_type; ?></td>
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
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center">No records found.</td></tr>
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