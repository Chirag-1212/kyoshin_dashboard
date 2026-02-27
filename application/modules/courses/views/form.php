<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <form role="form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($detail->id) ? $detail->id : ''; ?>">
            <div class="box-body">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Course Title (English)</label>
                            <input type="text" name="title_en" class="form-control" value="<?php echo isset($detail->title_en) ? $detail->title_en : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Course Title (Japanese)</label>
                            <input type="text" name="title_jp" class="form-control" value="<?php echo isset($detail->title_jp) ? $detail->title_jp : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sub-Level (e.g. Beginner, N5)</label>
                            <input type="text" name="sub_level" class="form-control" value="<?php echo isset($detail->sub_level) ? $detail->sub_level : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sub-Text (English)</label>
                            <input type="text" name="sub_text_en" class="form-control" value="<?php echo isset($detail->sub_text_en) ? $detail->sub_text_en : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sub-Text (Japanese)</label>
                            <input type="text" name="sub_text_jp" class="form-control" value="<?php echo isset($detail->sub_text_jp) ? $detail->sub_text_jp : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description (English)</label>
                    <textarea name="desc_en" class="form-control" rows="4"><?php echo isset($detail->desc_en) ? $detail->desc_en : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Description (Japanese)</label>
                    <textarea name="desc_jp" class="form-control" rows="4"><?php echo isset($detail->desc_jp) ? $detail->desc_jp : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Course Image</label>
                    <input type="file" name="docpath">
                    <input type="hidden" name="old_docpath" value="<?php echo isset($detail->docpath) ? $detail->docpath : ''; ?>">
                    <?php if (isset($detail->docpath) && $detail->docpath != ''): ?>
                        <div style="margin-top: 10px;">
                            <img src="<?php echo base_url($detail->docpath); ?>" style="height: 80px; border: 1px solid #ddd;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="width: 200px;">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?php echo (isset($detail->status) && $detail->status == '1') ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo (isset($detail->status) && $detail->status == '0') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Course</button>
                <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</section>