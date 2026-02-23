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
                    <?php echo validation_errors('<div class="error_message" style="color:red">', '</div>'); ?>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title/Post <span class="req">*</span></label>
                                    <input type="text" name="Title" class="form-control" id="Title" placeholder="Title"
                                        value="<?php echo set_value('Title', (((isset($detail->Title)) && $detail->Title != '') ? $detail->Title : '')); ?>"
                                        required>
                                    <?php echo form_error('Title', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TitleNepali</label>
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
                                    <select name="fiscal_id" class="form-control select2" id="fiscal_id">
                                        <option value>Select Fiscal Year</option>
                                        <?php foreach ($fiscal_years as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->fiscal_id)) && $detail->fiscal_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="Type" class="form-control Type" id="Type">
                                        <option value="">Select Type</option>
                                        <option value="news"
                                            <?php echo  set_select('Type', 'news', (isset($detail->Type) && $detail->Type == 'news') ? TRUE : ''); ?>>
                                            News & Events</option>
                                        <option value="notices"
                                            <?php echo  set_select('Type', 'notices', (isset($detail->Type) && $detail->Type == 'notices') ? TRUE : ''); ?>>
                                            Notices</option>
                                        <option value="career"
                                            <?php echo  set_select('Type', 'career', (isset($detail->Type) && $detail->Type == 'career') ? TRUE : ''); ?>>
                                            Career</option>
                                    </select>
                                    <?php echo form_error('Type', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="imp_notice" value="Y" <?= $detail && $detail->imp_notice=='Y' ? 'checked' : '' ?>>
                                <label>Important Notice</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="show_pop" value="Y" <?= $detail && $detail->show_pop=='Y' ? 'checked' : '' ?>>
                                <label>Show on Notification</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Publish Date </label>
                                    <input type="date" name="datevalue" class="form-control" id="datevalue"
                                        placeholder="Submit Date"
                                        value="<?php echo set_value('datevalue', (((isset($detail->datevalue)) && $detail->datevalue != '') ? $detail->datevalue : date('Y-m-d'))); ?>"
                                        required>
                                    <?php echo form_error('datevalue', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Due Date </label>
                                    <input type="date" name="due_date" class="form-control" id="due_date"
                                        placeholder="Submit Date"
                                        value="<?php echo set_value('due_date', (((isset($detail->due_date)) && $detail->due_date != '') ? $detail->due_date : date('Y-m-d'))); ?>"
                                        required>
                                    <?php echo form_error('due_date', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-md-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>Cover Image</label>-->
                            <!--        <input type="file" name="CoverImage" class="form-control" id="CoverImage"-->
                            <!--            placeholder="File" value="">-->
                                    <?php //echo form_error('CoverImage', '<div class="error_message">', '</div>');
                ?>
                                    <?php //echo (isset($detail->CoverImage) && $detail->CoverImage != '') ? "<a href='" . base_url() .  $detail->CoverImage . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="DocPath" class="form-control" id="DocPath"
                                        placeholder="File" value="">
                                    <?php echo form_error('DocPath', '<div class="error_message">', '</div>');
                ?>
                                    <?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url(). $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="Description" id="description" class="form-control" rows="5"
                                        cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->Description)) && $detail->Description != '') ? $detail->Description : '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description Nepali</label>
                                    <textarea name="DescriptionNepali" id="DescriptionNepali" class="form-control"
                                        rows="5" cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->DescriptionNepali)) && $detail->DescriptionNepali != '') ? $detail->DescriptionNepali : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="career">
                            <!--<div class="col-md-4">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>Start Date</label>-->
                            <!--        <input type="date" name="StartDate" class="form-control" id="StartDate" placeholder="Start Date"-->
                            <!--            value="<?php echo set_value('StartDate', (((isset($detail->StartDate)) && $detail->StartDate != '') ? $detail->StartDate : '')); ?>"-->
                            <!--            >-->
                            <!--        <?php echo form_error('StartDate', '<div class="error_message">', '</div>'); ?>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>End Date</label>-->
                            <!--        <input type="date" name="EndDate" class="form-control" id="EndDate" placeholder="End Date"-->
                            <!--            value="<?php echo set_value('EndDate', (((isset($detail->EndDate)) && $detail->EndDate != '') ? $detail->EndDate : '')); ?>"-->
                            <!--            >-->
                            <!--        <?php echo form_error('EndDate', '<div class="error_message">', '</div>'); ?>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Job Number</label>
                                    <input type="number" name="JobNumber" class="form-control" id="JobNumber" placeholder="Job Number"
                                        value="<?php echo set_value('JobNumber', (((isset($detail->JobNumber)) && $detail->JobNumber != '') ? $detail->JobNumber : '')); ?>"
                                        >
                                    <?php echo form_error('JobNumber', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <input type="text" name="Duration" class="form-control" id="Duration" placeholder="Duration"
                                        value="<?php echo set_value('Duration', (((isset($detail->Duration)) && $detail->Duration != '') ? $detail->Duration : '')); ?>"
                                        >
                                    <?php echo form_error('Duration', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Experience <span>In Year</span></label>
                                    <input type="number" name="Experience" class="form-control" id="Experience" placeholder="Experience"
                                        value="<?php echo set_value('Experience', (((isset($detail->Experience)) && $detail->Experience != '') ? $detail->Experience : '')); ?>"
                                        >
                                    <?php echo form_error('Experience', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    
                                    <select name="branch_id[]" class="form-control select2" id="branch_id" multiple>
                                    <option value="">Select Branch</option>
                                    <?php 
                                    // Get selected branch IDs as an array
                                    $selectedBranchIds = isset($detail->branch_id) ? explode(',', $detail->branch_id) : [];
                                
                                    // Loop through all branches
                                    foreach ($branches as $branch): ?>
                                        <option value="<?php echo $branch->id; ?>"
                                            <?php echo set_select('branch_id', $branch->id, in_array($branch->id, $selectedBranchIds)); ?>>
                                            <?php echo $branch->PageTitle; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                         <option value="4"
                                        <?php echo  set_select('status', '4', (isset($detail->status) && $detail->status == '4') ? TRUE : ''); ?>>
                                        Show on Popup Only</option>
                                         <option value="3"
                                        <?php echo  set_select('status', '3', (isset($detail->status) && $detail->status == '3') ? TRUE : ''); ?>>
                                        Show on Popup & Notice</option>
                                        <option value="1"
                                            <?php echo  set_select('status', '1', (isset($detail->status) && $detail->status == '1') ? TRUE : ''); ?>>
                                            Show on Notice Only</option>
                                        <option value="0"
                                            <?php echo  set_select('status', '0', (isset($detail->status) && $detail->status == '0') ? TRUE : ''); ?>>
                                            Inactive</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
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