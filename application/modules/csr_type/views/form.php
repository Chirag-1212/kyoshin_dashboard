<section class="content">
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
                            <input type="text" name="Title" class="form-control" id="Title" placeholder="Title"
                                value="<?php echo set_value('Title', (((isset($detail->Title)) && $detail->Title != '') ? $detail->Title : '')); ?>"
                                required>
                            <?php echo form_error('Title', '<div class="error_message">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title Nepali</label>
                            <input type="text" name="TitleNepali" class="form-control" id="TitleNepali"
                                placeholder="Title Nepali"
                                value="<?php echo set_value('TitleNepali', (((isset($detail->TitleNepali)) && $detail->TitleNepali != '') ? $detail->TitleNepali : '')); ?>">
                            <?php echo form_error('TitleNepali', '<div class="error_message">', '</div>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-md-6">-->
                    <!--  <div class="form-group">-->
                    <!--    <label>Date </label>-->
                    <!--    <input type="date" name="datevalue" class="form-control" id="datevalue" placeholder="Submit Date" value="<?php echo set_value('datevalue', (((isset($detail->datevalue)) && $detail->datevalue != '') ? $detail->datevalue : date('Y-m-d'))); ?>" required>-->
                    <!--    <?php echo form_error('datevalue', '<div class="error_message">', '</div>'); ?>-->
                    <!--  </div>-->
                    <!--</div>-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="parent_id" class="form-control select2" id="parent_id">
                                <?php echo $html; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" name="DocPath" class="form-control" id="DocPath" placeholder="File"
                                value="">
                            <?php echo form_error('DocPath', '<div class="error_message">', '</div>');
                ?>
                            <?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url() . $doc_path . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Remark</label>
                            <textarea name="remark" id="remark" class="form-control" rows="5" cols="80"
                                autocomplete="off"><?php echo (((isset($detail->remark)) && $detail->remark != '') ? $detail->remark : '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Serial</label>
                            <input type="number" name="serial" class="form-control" id="serial" placeholder="serial"
                                value="<?php echo set_value('serial', (((isset($detail->serial)) && $detail->serial != '') ? $detail->serial : '')); ?>">

                        </div>
                    </div>
                    <!--<div class="col-md-6">-->
                    <!--  <div class="form-group">-->
                    <!--    <label>Description Nepali</label>-->
                    <!--    <textarea name="DescriptionNepali" id="DescriptionNepali" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->DescriptionNepali)) && $detail->DescriptionNepali != '') ? $detail->DescriptionNepali : '') ?></textarea>-->
                    <!--  </div>-->
                    <!--</div>-->
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
                            <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit"
                                value="Save">
                            <input type="hidden" name="id" class="form-control btn btn-sm btn-primary" id="submit"
                                value="<?php echo (((isset($detail->id)) && $detail->id != '') ? $detail->id : '') ?>">
                        </div>
                    </div>
                </div>
            </div>
    </form>
    </div>
</section>