<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>
            
            <?php echo form_open_multipart($redirect . '/form/' . ($detail->id ?? '')); ?>
            <div class="box-body">
                <input type="hidden" name="id" value="<?= $detail->id ?? ''; ?>">
                
                <div class="form-group">
                    <label>select news article</label>
                    <select name="news_id" class="form-control" required>
                        <option value="">-- select news --</option>
                        <?php foreach ($news as $n): ?>
                            <option value="<?= $n->id; ?>" <?= (isset($detail) && $detail->news_id == $n->id) ? 'selected' : ''; ?>>
                                <?= $n->title_en ?? $n->id; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>image file</label>
                    <input type="file" name="docpath" class="form-control" <?= empty($detail) ? 'required' : ''; ?>>
                    <input type="hidden" name="old_docpath" value="<?= $detail->docpath ?? ''; ?>">
                    <?php if (!empty($detail->docpath)): ?>
                        <img src="<?= base_url($detail->docpath); ?>" width="100" class="mt-2">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($detail) && $detail->status == 1) ? 'selected' : ''; ?>>active</option>
                        <option value="2" <?= (isset($detail) && $detail->status == 2) ? 'selected' : ''; ?>>deleted</option>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">save</button>
                <a href="<?= base_url($redirect . '/all'); ?>" class="btn btn-default">cancel</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>