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
                            <!-- <div class="col-md-4">
              <div class="form-group">
                <label>Zoom Level</label>
                <select name="zoom_level" class="form-control selct2" id="zoom_level">
                  <option value="100" <?php //echo  set_select('zoom_level', '100', (isset($detail->zoom_level) && $detail->zoom_level == '100') ? TRUE : ''); 
                                      ?>>No Zoom</option>
                  <option value="200" <?php //echo  set_select('zoom_level', '200', (isset($detail->zoom_level) && $detail->zoom_level == '200') ? TRUE : ''); 
                                      ?>>x2</option>
                  <option value="300" <?php //echo  set_select('zoom_level', '300', (isset($detail->zoom_level) && $detail->zoom_level == '300') ? TRUE : ''); 
                                      ?>>x3</option>
                  <option value="400" <?php //echo  set_select('zoom_level', '400', (isset($detail->zoom_level) && $detail->zoom_level == '400') ? TRUE : ''); 
                                      ?>>x4</option>
                  <option value="500" <?php //echo  set_select('zoom_level', '500', (isset($detail->zoom_level) && $detail->zoom_level == '500') ? TRUE : ''); 
                                      ?>>x5</option>
                  <option value="600" <?php //echo  set_select('zoom_level', '600', (isset($detail->zoom_level) && $detail->zoom_level == '600') ? TRUE : ''); 
                                      ?>>x6</option>
                  <option value="700" <?php //echo  set_select('zoom_level', '700', (isset($detail->zoom_level) && $detail->zoom_level == '700') ? TRUE : ''); 
                                      ?>>x7</option>
                  <option value="800" <?php //echo  set_select('zoom_level', '800', (isset($detail->zoom_level) && $detail->zoom_level == '800') ? TRUE : ''); 
                                      ?>>x8</option>
                  <option value="900" <?php //echo  set_select('zoom_level', '900', (isset($detail->zoom_level) && $detail->zoom_level == '900') ? TRUE : ''); 
                                      ?>>x9</option>
                  <option value="1000" <?php //echo  set_select('zoom_level', '1000', (isset($detail->zoom_level) && $detail->zoom_level == '1000') ? TRUE : ''); 
                                        ?>>x10</option>
                </select>
              </div>
            </div>  -->
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serial</label>
                                    <input type="number" name="Serial" class="form-control" id="Serial"
                                        placeholder="Serial"
                                        value="<?php echo set_value('Serial', (((isset($detail->Serial)) && $detail->Serial != '') ? $detail->Serial : '')); ?>">
                                    <?php echo form_error('Serial', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>External Link</label>
                                    <input type="text" name="Link" class="form-control" id="Link"
                                        placeholder="External Link"
                                        value="<?php echo set_value('Link', (((isset($detail->Link)) && $detail->Link != '') ? $detail->Link : '')); ?>">
                                    <?php echo form_error('Link', '<div class="error_message">', '</div>'); ?>
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