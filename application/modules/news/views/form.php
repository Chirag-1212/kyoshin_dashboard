<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>

            <?= form_open_multipart($redirect . '/form/' . ($detail->id ?? '')); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $detail->id ?? ''; ?>">
                    <input type="hidden" name="old_docpath" value="<?= $detail->docpath ?? ''; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (English)</label>
                                <input type="text" name="title_en" class="form-control" value="<?= $detail->title_en ?? ''; ?>" required>
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
                                <textarea name="desc_en" class="form-control" rows="4"><?= $detail->desc_en ?? ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description (Japanese)</label>
                                <textarea name="desc_jp" class="form-control" rows="4"><?= $detail->desc_jp ?? ''; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Main Image</label>
                                <input type="file" name="docpath" class="form-control">
                                <?php if (!empty($detail->docpath)): ?>
                                    <img src="<?= base_url($detail->docpath); ?>" class="img-thumbnail" style="margin-top:10px; height:80px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Secondary Image (news_image)</label>
                                <input type="file" name="news_image" class="form-control">
                                <?php if (!empty($related_image->docpath)): ?>
                                    <img src="<?= base_url($related_image->docpath); ?>" class="img-thumbnail" style="margin-top:10px; height:80px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" <?= (isset($detail) && $detail->status == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="2" <?= (isset($detail) && $detail->status == 2) ? 'selected' : ''; ?>>Deleted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save News Data</button>
                    <a href="<?= base_url($redirect . '/all'); ?>" class="btn btn-default">Cancel</a>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>