<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <form role="form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $detail->id ?? ''; ?>">
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="submitdt" class="form-control" value="<?php echo $detail->submitdt ?? date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo $detail->title ?? ''; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Banner File</label>
                            <input type="file" name="docpath"> <input type="hidden" name="old_docpath" value="<?php echo $detail->docpath ?? ''; ?>">
                            <?php if(!empty($detail->docpath)): ?>
                                <p class="help-block"><a href="<?php echo base_url($detail->docpath); ?>" target="_blank">View current file</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File Type</label>
                            <select name="file_type" class="form-control"> <option value="image" <?php echo (isset($detail->file_type) && $detail->file_type == 'image') ? 'selected' : ''; ?>>Image</option>
                                <option value="video" <?php echo (isset($detail->file_type) && $detail->file_type == 'video') ? 'selected' : ''; ?>>Video</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Order</label>
                            <input type="number" name="border" class="form-control" value="<?php echo $detail->border ?? 0; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Target</label>
                            <select name="target" class="form-control">
                                <option value="_self" <?php echo (isset($detail->target) && $detail->target == '_self') ? 'selected' : ''; ?>>Same Window</option>
                                <option value="_blank" <?php echo (isset($detail->target) && $detail->target == '_blank') ? 'selected' : ''; ?>>New Tab</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" <?php echo (isset($detail->status) && $detail->status == '1') ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo (isset($detail->status) && $detail->status == '0') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo $detail->description ?? ''; ?></textarea>
                </div>
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>