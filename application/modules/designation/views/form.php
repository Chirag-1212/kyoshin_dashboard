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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Designation Name <span class="req">*</span></label>
                                    <input type="text" name="designation_name" class="form-control"
                                        id="designation_name" placeholder="Designation Name"
                                        value="<?php echo set_value('designation_name', (((isset($detail->designation_name)) && $detail->designation_name != '')? $detail->designation_name : '')); ?>">
                                    <?php echo form_error('designation_name', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Designation Name In Nepali</label>
                                    <input type="text" name="designation_name_np" class="form-control" id="designation_name_np"
                                        placeholder="designation_name_np"
                                        value="<?php echo set_value('designation_name_np', (((isset($detail->designation_name_np)) && $detail->designation_name_np != '')? $detail->designation_name_np : '')); ?>">
                                    <?php echo form_error('designation_name_np', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Designation Code <span class="req">*</span></label>
                                    <input type="text" name="designation_code" class="form-control"
                                        id="designation_code" placeholder="Designation Name"
                                        value="<?php echo set_value('designation_code', (((isset($detail->designation_code)) && $detail->designation_code != '')? $detail->designation_code : '')); ?>">
                                    <?php echo form_error('designation_code', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" name="remarks" class="form-control" id="remarks"
                                        placeholder="Remarks"
                                        value="<?php echo set_value('remarks', (((isset($detail->remarks)) && $detail->remarks != '')? $detail->remarks : '')); ?>">
                                    <?php echo form_error('remarks', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
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