<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <?= form_open_multipart($redirect . '/form/' . ($detail->id ?? ''), ['class' => 'form-horizontal']); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $detail->id ?? ''; ?>">
                    <input type="hidden" name="old_docpath" value="<?= $detail->docpath ?? ''; ?>">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">description</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" rows="3" placeholder="enter description (optional)"><?= $detail->description ?? ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">upload image</label>
                        <div class="col-sm-9">
                            <input type="file" name="docpath" class="form-control">
                            <?php if (!empty($detail->docpath)): ?>
                                <div class="mt-2"><img src="<?= base_url($detail->docpath); ?>" width="150" class="img-thumbnail"></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">status</label>
                        <div class="col-sm-9">
                            <select name="status" class="form-control">
                                <option value="1" <?= (isset($detail) && $detail->status == 1) ? 'selected' : ''; ?>>active</option>
                                <option value="0" <?= (isset($detail) && $detail->status == 0) ? 'selected' : ''; ?>>inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">save</button>
                        <a href="<?= base_url($redirect . '/all'); ?>" class="btn btn-default">cancel</a>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>