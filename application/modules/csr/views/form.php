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
                        </div>
                        <div class="row">
                            <!--  <div class="col-md-6">-->
                            <!--  <div class="form-group">-->
                            <!--    <label>Select Category</label>-->
                            <!--    <select name="csr_type_id" class="form-control selct2" id="csr_type_id">-->
                            <!--      <option value>Select Category</option>-->
                            <!--      <?php foreach ($categories as $key => $value) { ?>-->
                            <!--        <option value="<?php echo $value->id ?>" <?php echo (((isset($detail->csr_type_id)) && $detail->csr_type_id == $value->id) ? 'selected' : '') ?>><?php echo $value->Title; ?></option>-->
                            <!--      <?php } ?>-->
                            <!--    </select>-->
                            <!--  </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>Category Name <span style="color:red;"> *</span></label>-->
                            <!--        <select name="csr_type_id" class="form-control" id="csr_type_id">-->
                            <!--            <?php echo $html; ?>-->
                            <!--        </select>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date </label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="DocPath" class="form-control" id="DocPath"
                                        placeholder="File" value="">
                                    <?php echo form_error('DocPath', '<div class="error_message">', '</div>');
                ?>
                                    <?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url()  . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cover Image</label>
                                    <input type="file" name="CoverImage" class="form-control" id="CoverImage"
                                        placeholder="CoverImage" value="">
                                    <?php echo form_error('CoverImage', '<div class="error_message">', '</div>');
                ?>
                                    <?php echo (isset($detail->CoverImage) && $detail->CoverImage != '') ? "<a href='" . base_url()  . $detail->CoverImage . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Multiple Files</label>
                                    <input type="file" class="form-control" name="files[]" multiple/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="show_pop" value="Y" <?= $detail && $detail->show_pop=='Y' ? 'checked' : '' ?>>
                                <label>Show on Notification</label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">  
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>   
                                  <th>Image</th>
                                
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    if(!empty($items)){ 
                                        foreach($items as $key => $value){  
                                            
                                ?>
                                <tr>
                                  <td><?php echo $key+1 ?></td>
                                  <td><?php if($value->DocPath){ ?><img src="<?php echo base_url($value->DocPath); ?>" class="img-fluid" style="max-height: 150px;object-fit: contain;"><?php } ?></td> 
                              
                                  <td>                         
                                     
                                      <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $value->id; ?>">Delete</a> 
            
                                      <div class="modal fade" id="exampleModal<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            Are You Sure To Delete?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <a href="<?php echo base_url('csr/admin/detail_delete/'.$value->id); ?>" class="btn btn-primary">Yes</a>
                                            </div>
                                            </div>
                                        </div>
                                      </div>
                                      
                                  </td>
                                </tr> 
                                <?php } ?>
                                
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">No Records Found</td>
                                    </tr>
                                <?php } ?>
                              </tbody>
                            </table>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                         <option value="4"<?php echo  set_select('status', '4', (isset($detail->status) && $detail->status == '4') ? TRUE : ''); ?>>
                                        Show on Popup Only</option>
                                         <option value="3"
                                        <?php echo  set_select('status', '3', (isset($detail->status) && $detail->status == '3') ? TRUE : ''); ?>>
                                        Show on Popup & CSR</option>
                                        <option value="1"
                                            <?php echo  set_select('status', '1', (isset($detail->status) && $detail->status == '1') ? TRUE : ''); ?>>
                                        Show on CSR Only</option>
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