<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
                
                <form class="all_form" method="post" action="" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title <span class="req">*</span></label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="title"
                                        value="<?php echo set_value('title', (isset($detail->title) ? $detail->title : '')); ?>"
                                        required>
                                    <?php echo form_error('title', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title Japanese</label>
                                    <input type="text" name="title_jp" class="form-control" id="title_jp"
                                        placeholder="title japanese"
                                        value="<?php echo set_value('title_jp', (isset($detail->title_jp) ? $detail->title_jp : '')); ?>">
                                    <?php echo form_error('title_jp', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subtitle</label>
                                    <input type="text" name="sub_title" class="form-control" id="sub_title"
                                        placeholder="subtitle"
                                        value="<?php echo set_value('sub_title', (isset($detail->sub_title) ? $detail->sub_title : '')); ?>">
                                    <?php echo form_error('sub_title', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subtitle Japanese</label>
                                    <input type="text" name="sub_title_jp" class="form-control" id="sub_title_jp"
                                        placeholder="subtitle japanese"
                                        value="<?php echo set_value('sub_title_jp', (isset($detail->sub_title_jp) ? $detail->sub_title_jp : '')); ?>">
                                    <?php echo form_error('sub_title_jp', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="doc_path" class="form-control" id="doc_path">
                                    <input type="hidden" name="old_doc_path" value="<?php echo isset($detail->doc_path) ? $detail->doc_path : ''; ?>">
                                    
                                    <?php if (isset($detail->doc_path) && $detail->doc_path != ''): ?>
                                        <br>
                                        <a href="<?php echo base_url($detail->doc_path); ?>" class="btn btn-sm btn-info" target="_blank">view current file</a>
                                    <?php endif; ?>
                                    <?php echo form_error('doc_path', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="1" <?php echo set_select('status', '1', (isset($detail->status) && $detail->status == '1')); ?>>active</option>
                                        <option value="0" <?php echo set_select('status', '0', (isset($detail->status) && $detail->status == '0')); ?>>inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5"
                                        required><?php echo set_value('description', (isset($detail->description) ? $detail->description : '')); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description Japanese</label>
                                    <textarea name="description_jp" id="description_jp" class="form-control"
                                        rows="5"><?php echo set_value('description_jp', (isset($detail->description_jp) ? $detail->description_jp : '')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php echo isset($detail->id) ? $detail->id : ''; ?>">
                        <input type="submit" name="submit" class="btn btn-primary" id="submit" value="save">
                        <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default">cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>