<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title; ?> Details</h3>
            </div>
            <?php echo form_open(); ?>
            <div class="card-body">
                <input type="hidden" name="id" value="<?php echo @$detail->id; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?php echo set_value('title', @$detail->title); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_id" class="form-control">
                                <option value="0">None (Top Level)</option>
                                <?php foreach($parents as $p): ?>
                                    <option value="<?php echo $p->id; ?>" <?php echo (@$detail->parent_id == $p->id) ? 'selected' : ''; ?>>
                                        <?php echo $p->title; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" <?php echo (@$detail->status == '1') ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo (@$detail->status == '0') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Category</button>
                <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-secondary float-right">Cancel</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>