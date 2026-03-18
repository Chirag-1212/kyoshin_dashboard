<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <a href="<?php echo base_url($form_link); ?>" class="btn btn-sm btn-primary">Add New</a>
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
                            <tr>
                                <th>S.N.</th>
                                <th>Category Title</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): ?>
                                <?php 
                                $i = $this->uri->segment(4) ? $this->uri->segment(4) + 1 : 1; 
                                foreach ($items as $row): 
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><strong><?php echo $row->title; ?></strong></td>
                                    <td>
                                        <?php if ($row->parent_id == '1'): ?>
                                            <span class="label label-info">yes</span>
                                        <?php else: ?>
                                            <span class="label label-default">no</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row->status == '1'): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url($redirect . '/admin/form/' . $row->id); ?>" 
                                           class="btn btn-xs btn-primary" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?php echo base_url($delete_link . $row->id); ?>" 
                                           class="btn btn-xs btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this?');" 
                                           title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center" style="padding: 20px;">
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