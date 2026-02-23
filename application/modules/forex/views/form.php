<section class="content">
    < class="row">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date <span class="req">*</span></label>
                                    <input type="date" name="Date" class="form-control" id="Date"
                                        placeholder="Submit Date"
                                        value="<?php echo set_value('Date', (((isset($detail->Date)) && $detail->Date != '') ? $detail->Date : date('Y-m-d'))); ?>"
                                        required>
                                    <?php echo form_error('Date', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Time <span class="req">*</span></label>
                                    <input type="time" name="Time" class="form-control" id="Time"
                                        placeholder="Submit Time"
                                        value="<?php echo set_value('Time', (((isset($detail->Time)) && $detail->Time != '') ? $detail->Time : date('H:i:s'))); ?>"
                                        required>
                                    <?php echo form_error('Time', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="FileName" class="form-control" id="FileName"
                                        placeholder="File" value="">
                                    <?php echo form_error('FileName', '<div class="error_message">', '</div>');
                ?>
                                    <?php echo (isset($detail->FileName) && $detail->FileName != '') ? "<a href='" . base_url() . $doc_path . $detail->FileName . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
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