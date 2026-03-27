<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="all_form" method="post" action enctype="multipart/form-data">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $title ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-remove"></i></button>
                        </div>
                    </div>
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
                                    <label>Number </label>
                                    <input type="number" name="number" class="form-control" id="number"
                                        placeholder="number"
                                        value="<?php echo set_value('number', (isset($detail->number) ? $detail->number : '')); ?>">
                                    <?php echo form_error('number', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Number Japanese</label>
                                    <input type="text" name="number_jp" class="form-control" id="number_jp"
                                        placeholder="number japanese"
                                        value="<?php echo set_value('number_jp', (isset($detail->number_jp) ? $detail->number_jp : '')); ?>">
                                    <?php echo form_error('number_jp', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="1"
                                            <?php echo set_select('status', '1', (isset($detail->status) && $detail->status == '1') ? TRUE : ''); ?>>
                                            Active</option>
                                        <option value="0"
                                            <?php echo set_select('status', '0', (isset($detail->status) && $detail->status == '0') ? TRUE : ''); ?>>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-sm btn-primary"
                                        id="submit" value="save">
                                    
                                    <a href="<?php echo base_url($redirect . '/admin/all'); ?>" 
                                       class="btn btn-sm btn-default" 
                                       style="margin-left: 5px;">Cancel</a>
                                </div>
                                
                                <input type="hidden" name="id"
                                    value="<?php echo (isset($detail->id) ? $detail->id : '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>