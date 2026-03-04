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
                            <th style="width: 60px; text-align: center;">SN</th>
                            <th>Category Title</th>
                            <th>Slug</th>
                            <th style="width: 100px; text-align: center;">Status</th>
                            <th style="width: 150px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): 
                            $sn = $offset + 1; 
                            foreach ($items as $row): ?>
                            <tr>
                                <td class="text-center"><?php echo $sn++; ?></td>
                                <td><strong><?php echo $row->title; ?></strong></td>
                                <td><small class="text-muted"><?php echo $row->slug; ?></small></td>
                                <td class="text-center">
                                    <?php echo ($row->status == '1') ? 
                                        '<span class="badge badge-success">Active</span>' : 
                                        '<span class="badge badge-warning">Inactive</span>'; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center p-4">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix"><?php echo $pagination; ?></div>
        </div>
    </div>
</section>