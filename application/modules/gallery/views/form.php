<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="all_form" method="post" action="" enctype="multipart/form-data">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $title ?></h3>
                    </div>
                    
                    <?php echo validation_errors('<div class="error_message" style="color:red">', '</div>'); ?>
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>title(english) <span>*</span></label>
                                    <input type="text" name="title" class="form-control" value="<?= @$detail->title ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>title(japanee)</label>
                                    <input type="text" name="title_nepali" class="form-control" value="<?= @$detail->title_nepali ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>cover image</label>
                                    <input type="file" name="coverimage" class="form-control">
                                    <?php if (@$detail->coverimage): ?>
                                        <img src="<?= base_url(@$detail->coverimage) ?>" class="img-fluid mt-2" style="max-height: 200px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" <?= @$detail->status == '1' ? 'selected' : '' ?>>active</option>
                                        <option value="0" <?= @$detail->status == '0' ? 'selected' : '' ?>>inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>description</label>
                                    <textarea name="description" class="form-control" rows="5"><?= @$detail->description ?></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= @$detail->id ?>">
                        
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-flat">save</button>
                                    
                                    <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default btn-flat">cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>