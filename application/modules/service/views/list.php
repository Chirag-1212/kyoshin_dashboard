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
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-gray">
                        <th style="width: 50px; text-align: center;">SN</th>
                        <th style="width: 100px; text-align: center;">Image</th>
                        <th>Name / Title</th>
                        <th>Category</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 120px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)): ?>
                        <?php 
                        // Logic for sequential serial numbers across pagination
                        $i = $this->uri->segment(4) ? $this->uri->segment(4) + 1 : 1;
                        foreach ($list as $row): 
                        ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;"><?php echo $i++; ?></td>
                            <td style="text-align: center; vertical-align: middle;">
                                <?php if(!empty($row->docpath)): ?>
                                    <img src="<?php echo base_url($row->docpath); ?>" style="height: 40px; width: 60px; object-fit: cover; border: 1px solid #ddd;" class="img-thumbnail">
                                <?php else: ?>
                                    <i class="fa fa-image fa-2x text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <strong><?php echo $row->title_en; ?></strong>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="label label-info"><?php echo ucfirst($row->category ?? $row->sub_level); ?></span>
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
                                    <a href="<?php echo base_url($form_link .'/'. $row->id); ?>" class="btn btn-sm btn-default" title="Edit">
                                        <i class="fa fa-pencil text-primary"></i>
                                    </a>
                                    <a href="<?php echo base_url($delete_link .'/'. $row->id); ?>" class="btn btn-sm btn-default" title="Delete" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 30px;">
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