<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#type').change(function() {
            
            var selectedType = $(this).val();
            if (selectedType == 'Commissions') {
                $('#descriptionFields').show();
            } else {
                $('#descriptionFields').hide();
            }
        });
    });
</script><section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="all_form" method="post" action enctype="multipart/form-data">
                <div class="box box-default">
                    <div class="box-header ">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Fiscal Year</label>
                                    <select name="category_id" class="form-control select2" id="category_id">
                                        <option value>Select Group</option>
                                        <?php foreach ($fiscal_years as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->category_id)) && $detail->category_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->title; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('category_id', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input type="number" step="0.001" name="rate" class="form-control" id="rate"
                                        placeholder="Rate"
                                        value="<?php echo set_value('rate', (((isset($detail->rate)) && $detail->rate != '') ? $detail->rate : '')); ?>">
                                    <?php echo form_error('rate', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Average Rate</label>
                                    <input type="number" step="0.001" name="avg_rates" class="form-control" id="avg_rates"
                                        placeholder="Average Rate"
                                        value="<?php echo set_value('avg_rates', (((isset($detail->avg_rates)) && $detail->avg_rates != '') ? $detail->avg_rates : '')); ?>">
                                    <?php echo form_error('avg_rates', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
              <div class="form-group">
                <label>File</label>
                <input type="file" name="DocPath" class="form-control" id="DocPath" placeholder="File" value="">
                <?php //echo form_error('DocPath', '<div class="error_message">', '</div>');
                ?>
                <?php //echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url() . $doc_path . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
              </div>
            </div> -->
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control select2" id="type">
                                        <option value="Base"
                                            <?php echo  set_select('type', 'Base', (isset($detail->type) && $detail->type == 'Base') ? TRUE : ''); ?>>
                                            Base Rate</option>
                                        <option value="Spread"
                                            <?php echo  set_select('type', 'Spread', (isset($detail->type) && $detail->type == 'Spread') ? TRUE : ''); ?>>
                                            Spread Rate</option>
                                        <option value="Commissions"
                                            <?php echo  set_select('type', 'Commissions', (isset($detail->type) && $detail->type == 'Commissions') ? TRUE : ''); ?>>
                                            Fee Charge Commissions</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                        <div class="row" id="descriptionFields"  style="<?php echo $detail->type === 'Commissions' ? 'display: block;' : 'display: none;'; ?>">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="Description" id="description" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->Description)) && $detail->Description != '') ? $detail->Description : '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description Nepali</label>
                                    <textarea name="DescriptionNepali" id="DescriptionNepali" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->DescriptionNepali)) && $detail->DescriptionNepali != '') ? $detail->DescriptionNepali : '') ?></textarea>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Serial No. <span class="req">*</span></label>
                                    <input type="number" name="serial" class="form-control" id="serial" placeholder="serial"
                                        value="<?php echo set_value('serial', (((isset($detail->serial)) && $detail->serial != '') ? $detail->serial : '')); ?>"
                                        required>
                                    <?php echo form_error('serial', '<div class="error_message">', '</div>'); ?>
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
                </div>
            </form>
        </div>
    </div>
</section>
