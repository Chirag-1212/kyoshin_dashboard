<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?> Details</h3>
                </div>
                
                <?php echo form_open_multipart('', ['class' => 'all_form']); ?>
                    <div class="box-body">
                        <input type="hidden" name="id" value="<?php echo @$detail->id; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" 
                                           placeholder="Enter Category Title"
                                           value="<?php echo set_value('title', @$detail->title); ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Is this a sub-category?</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default <?php echo (@$detail->parent_id == 1) ? 'active' : ''; ?>">
                                            <input type="radio" name="parent_id" value="1" <?php echo (@$detail->parent_id == 1) ? 'checked' : ''; ?>> Yes
                                        </label>
                                        <label class="btn btn-default <?php echo (@$detail->parent_id != 1) ? 'active' : ''; ?>">
                                            <input type="radio" name="parent_id" value="2" <?php echo (@$detail->parent_id != 1) ? 'checked' : ''; ?>> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
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

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save Category</button>
                        <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default">Cancel</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>