<section class="content">
    <div class="container-fluid">
        
        <?php $this->load->view('search'); ?>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title; ?> Management</h3>
                <div class="card-tools">
                    <a href="<?php echo base_url($redirect . '/admin/form'); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr class="bg-light">
                            <th style="width: 50px; text-align: center;">#</th>
                            <th style="width: 80px; text-align: center;">Image</th>
                            <th>Name / Title</th>
                            <th>Category</th>
                            <th style="width: 100px; text-align: center;">Status</th>
                            <th style="width: 150px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): 
                            $sn = $offset + 1; 
                            foreach ($items as $row): ?>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;"><?php echo $sn++; ?></td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if(!empty($row->docpath)): ?>
                                        <img src="<?php echo base_url($row->docpath); ?>" style="height: 40px; width: 60px; object-fit: cover; border: 1px solid #ddd;" class="shadow-sm">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    <?php endif; ?>
                                </td>
                                <td style="vertical-align: middle;">
                                    <strong><?php echo $row->title_en; ?></strong>
                                </td>
                                <td style="vertical-align: middle;">
                                    <span class="badge badge-info"><?php echo ucfirst($row->category); ?></span>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if ($row->status == '1'): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="<?php echo base_url($form_link . $row->id); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url($delete_link . $row->id); ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 30px;">
                                    <i class="fas fa-folder-open fa-2x text-muted d-block mb-2"></i>
                                    No records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</section>