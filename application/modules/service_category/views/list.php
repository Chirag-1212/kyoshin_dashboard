<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?> List</h3>
            <div class="box-tools">
                <a href="<?php echo base_url($form_link); ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
        </div>
        
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr class="bg-gray">
                        <th style="width: 60px; text-align: center;">SN</th>
                        <th>Category Title</th>
                        <th>Slug</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 120px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php 
                        // Synchronizing SN logic with your previous code
                        $i = $this->uri->segment(4) ? $this->uri->segment(4) + 1 : 1; 
                        foreach ($items as $row): 
                        ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;"><?php echo $i++; ?></td>
                            <td style="vertical-align: middle;">
                                <strong><?php echo $row->title; ?></strong>
                            </td>
                            <td style="vertical-align: middle;">
                                <small class="text-muted"><?php echo $row->slug; ?></small>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <?php if ($row->status == '1'): ?>
                                    <span class="label label-success">Active</span>
                                <?php else: ?>
                                    <span class="label label-warning">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <div class="btn-group">
                                    <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" class="btn btn-sm btn-default" title="Edit">
                                        <i class="fa fa-pencil text-primary"></i>
                                    </a>
                                    <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" class="btn btn-sm btn-default" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 30px;">
                                <i class="fa fa-folder-open-o fa-2x text-muted"></i><br>
                                No records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="box-footer clearfix">
            <div class="pull-right">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
</section>