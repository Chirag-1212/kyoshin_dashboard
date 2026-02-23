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
                                    <label>Date <span class="req">*</span></label>
                                    <input type="date" name="SubmitDt" class="form-control" id="SubmitDt"
                                        placeholder="Submit Date"
                                        value="<?php echo set_value('SubmitDt', (((isset($detail->SubmitDt)) && $detail->SubmitDt != '') ? $detail->SubmitDt : date('Y-m-d'))); ?>"
                                        required>
                                    <?php echo form_error('SubmitDt', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="DocPath" class="form-control" id="DocPath"
                                        placeholder="File" value="">
                                    <?php echo form_error('DocPath', '<div class="error_message">', '</div>');
                ?>
                                    <?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url() . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title <span class="req">*</span></label>
                                    <input type="text" name="Title" class="form-control" id="Title" placeholder="Title"
                                        value="<?php echo set_value('Title', (((isset($detail->Title)) && $detail->Title != '') ? $detail->Title : '')); ?>"
                                        required>
                                    <?php echo form_error('Title', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Order (Highest Order First)</label>
                                    <input type="number" name="BOrder" class="form-control" id="BOrder"
                                        placeholder="Order"
                                        value="<?php echo set_value('BOrder', (((isset($detail->BOrder)) && $detail->BOrder != '') ? $detail->BOrder : '')); ?>">
                                    <?php echo form_error('BOrder', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Open in Window</label>
                                    <select name="Target" class="form-control select2" id="Target">
                                        <option>Select One</option>
                                        <option value="_blank"
                                            <?php echo  set_select('Target', '_blank', (isset($detail->Target) && $detail->Target == '_blank') ? TRUE : ''); ?>>
                                            New Tab</option>
                                        <option value="new"
                                            <?php echo  set_select('Target', 'new', (isset($detail->Target) && $detail->Target == 'new') ? TRUE : ''); ?>>
                                            New Window</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>File Type</label>
                                    <select name="file_type" class="form-control select2" id="file_type">
                                        <option>Select One</option>
                                        <option value="video"
                                            <?php echo  set_select('file_type', 'video', (isset($detail->file_type) && $detail->file_type == 'video') ? TRUE : ''); ?>>
                                            Video</option>
                                        <option value="image"
                                            <?php echo  set_select('file_type', 'image', (isset($detail->file_type) && $detail->file_type == 'image') ? TRUE : ''); ?>>
                                            Image</option>
                                        <option value="digital_slider"
                                            <?php echo  set_select('file_type', 'digital_slider', (isset($detail->file_type) && $detail->file_type == 'digital_slider') ? TRUE : ''); ?>>
                                            Digital Slider</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="Description" id="description" class="form-control" rows="5"
                                        cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->Description)) && $detail->Description != '') ? $detail->Description : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="1"
                                            <?php echo  set_select('status', '1', (isset($detail->status) && $detail->status == '1') ? TRUE : ''); ?>>
                                            Active</option>
                                        <option value="0"
                                            <?php echo  set_select('status', '0', (isset($detail->status) && $detail->status == '0') ? TRUE : ''); ?>>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary"
                                        id="submit" value="Save">
                                    <input type="hidden" name="id" class="form-control btn btn-sm btn-primary"
                                        id="submit"
                                        value="<?php echo (((isset($detail->id)) && $detail->id != '') ? $detail->id : '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>