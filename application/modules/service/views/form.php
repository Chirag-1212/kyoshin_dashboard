<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title; ?> Details</h3>
            </div>
            <?php echo form_open_multipart(); ?>
            <div class="card-body">
                <input type="hidden" name="id" value="<?php echo isset($detail->id) ? $detail->id : ''; ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title (English) <span class="text-danger">*</span></label>
                            <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en', @$detail->title_en); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title (Japanese)</label>
                            <input type="text" name="title_jp" class="form-control" value="<?php echo set_value('title_jp', @$detail->title_jp); ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description (English)</label>
                            <textarea name="desc_en" class="form-control editor"><?php echo @$detail->desc_en; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description (Japanese)</label>
                            <textarea name="desc_jp" class="form-control editor"><?php echo @$detail->desc_jp; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Service Category</label>
                            <select name="service_category_id" class="form-control">
                                <?php echo $html; ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="datevalue" class="form-control" value="<?php echo @$detail->datevalue ? $detail->datevalue : date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Serial #</label>
                            <input type="number" name="serial" class="form-control" value="<?php echo @$detail->serial; ?>">
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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Document (PDF/Image)</label>
                            <input type="file" name="docpath" class="form-control-file">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cover Image</label>
                            <input type="file" name="coverimage" class="form-control-file">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Main Image</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save <?php echo $title; ?></button>
                <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-secondary float-right">Cancel</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>