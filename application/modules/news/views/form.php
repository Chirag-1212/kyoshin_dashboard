<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>

            <?php echo form_open_multipart($redirect . '/admin/form/' . (!empty($detail->id) ? $detail->id : '')); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $detail->id ?? ''; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (English)</label>
                                <input type="text" name="title_en" class="form-control" value="<?= $detail->title_en ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (Japanese)</label>
                                <input type="text" name="title_jp" class="form-control" value="<?= $detail->title_jp ?? ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (English)</label>
                                <textarea name="desc_en" class="form-control" rows="5"><?= $detail->desc_en ?? ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (Nepali)</label>
                                <textarea name="desc_jp" class="form-control" rows="5"><?= $detail->desc_jp ?? ''; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Main Image</label>
                        <input type="file" name="docpath" class="form-control">
                        <input type="hidden" name="old_docpath" value="<?= $detail->docpath ?? ''; ?>">
                        <?php if (!empty($detail->docpath)): ?>
                            <img src="<?= base_url($detail->docpath); ?>" style="width:100px; margin-top:10px;">
                        <?php endif; ?>
                    </div>

                    <hr>
                    
                    <div class="form-group">
                        <label>Add Gallery Images (Batch)</label>
                        <input type="file" name="gallery_images[]" class="form-control" multiple>
                    </div>

                    <?php if (!empty($gallery_images)): ?>
                        <div class="row">
                            <?php foreach ($gallery_images as $img): ?>
                                <div class="col-md-2">
                                    <img src="<?= base_url($img->docpath); ?>" class="img-thumbnail">
                                    <a href="<?= base_url($redirect . '/admin/delete_gallery_image/' . $img->id . '?news_id=' . $detail->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?= (isset($detail) && $detail->status == 1) ? 'selected' : ''; ?>>Active</option>
                            <option value="2" <?= (isset($detail) && $detail->status == 2) ? 'selected' : ''; ?>>Deleted</option>
                        </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save News</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>