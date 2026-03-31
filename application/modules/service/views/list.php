<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <a href="<?php echo base_url($form_link); ?>" class="btn btn-sm btn-primary">Add New</a>
                        <?php  ?>
                    </h3>
                    <div class="box-tools">
                        <form action="" method="get">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right"
                                    placeholder="Search"
                                    value="<?php echo $this->input->get('table_search'); ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr class="bg-gray">
                                <th style="width: 50px;">SN</th>
                                <th style="width: 100px;">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 100px; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list)): ?>
                                <?php 
                                $i = $this->uri->segment(4) ? $this->uri->segment(4) + 1 : 1;
                                foreach ($list as $row): 
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <?php 
                                                // Robust image detection logic
                                                $img_to_show = '';
                                                if(!empty($row->image)) { $img_to_show = $row->image; }
                                                elseif(!empty($row->coverimage)) { $img_to_show = $row->coverimage; }
                                                elseif(!empty($row->docpath)) {
                                                    $ext = pathinfo($row->docpath, PATHINFO_EXTENSION);
                                                    if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                                                        $img_to_show = $row->docpath;
                                                    }
                                                }

                                                if ($img_to_show != ''): 
                                            ?>
                                                <img src="<?php echo base_url($img_to_show); ?>" 
                                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                            <?php else: ?>
                                                <span class="label label-default">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo $row->title_en; ?></strong></td>
                                        <td>
                                            <span class="text-muted small"><?php echo !empty($row->category_name) ? $row->category_name : 'N/A'; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($row->status == 1): ?>
                                                <span class="label label-success">Active</span>
                                            <?php else: ?>
                                                <span class="label label-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" 
                                                   class="btn btn-xs btn-primary" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?php echo base_url($redirect . '/admin/soft_delete/' . $row->id); ?>" 
                                                   class="btn btn-xs btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this content?');" 
                                                   title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center" style="padding: 30px;">
                                        <i class="fa fa-folder-open-o fa-2x text-muted"></i><br>
                                        No records found. <a href="<?php echo base_url($form_link); ?>">Create one now</a>.
                                    </td>
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