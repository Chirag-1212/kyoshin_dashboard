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
                                    <label>Full Name <span>*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter Full Name"
                                        value="<?php echo (((isset($detail->name)) && $detail->name != '')? $detail->name : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="Enter Email"
                                        value="<?php echo (((isset($detail->email)) && $detail->email != '')? $detail->email : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name Nepali <span>*</span></label>
                                    <input type="text" name="name_nepali" class="form-control" id="name_nepali"
                                        placeholder="Enter Full Name Nepali"
                                        value="<?php echo (((isset($detail->name_nepali)) && $detail->name_nepali != '')? $detail->name_nepali : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile no.</label>
                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        placeholder="Enter Mobile"
                                        value="<?php echo (((isset($detail->mobile)) && $detail->mobile != '')? $detail->mobile : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control" id="contact"
                                        placeholder="Enter Contact"
                                        value="<?php echo (((isset($detail->contact)) && $detail->contact != '')? $detail->contact : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" name="featured_image" class="form-control" id="featured_image"
                                        placeholder="featured_image"
                                        value="<?php echo (((isset($detail->featured_image)) && $detail->featured_image != '')? $detail->featured_image : '') ?>"
                                        readonly="readonly">
                                    <?php if((isset($detail->featured_image)) && $detail->featured_image != ''){ ?>
                                    <img src="<?php echo base_url().$detail->featured_image; ?>" class="img_cl img-fluid"
                                        id="defff0" style="max-height: 675px;object-fit: contain;">
                                    <?php }else{ ?>
                                    <img src="" class="img_cl img-fluid" id="defff0"
                                        style="display:none;max-height: 675px;object-fit: contain;">
                                    <?php }?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Officer Type</label>
                                    <?php
                            $type = array('' => 'Select Officer Type', 'Grievance' => 'Grievance Officer','Information'=> 'Information Officer','Compliance'=> 'Compliance Officer');
                            echo form_dropdown('type', $type, set_value('type', isset($detail->type) ? $detail->type : ''), array('class' => 'form-control select2'));
                        ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select name="branch" class="form-control select2" id="branch">
                                        <option value>Select Branch</option>
                                        <?php foreach ($branches as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->branch)) && $detail->branch == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->PageTitle; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="1"
                                            <?php echo (((isset($detail->status)) && $detail->status == '1') ? 'selected' : '') ?>>
                                            Active</option>
                                        <option value="0"
                                            <?php echo (((isset($detail->status)) && $detail->status == '0') ? 'selected' : '') ?>>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Serial no.</label>
                                    <input type="number" name="serial" class="form-control" id="serial"
                                        placeholder="Enter Serial number"
                                        value="<?php echo (((isset($detail->serial)) && $detail->serial != '')? $detail->serial : '') ?>">
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
                                        value="<?php echo (((isset($detail->id)) && $detail->id != '')? $detail->id : '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
function responsive_filemanager_callback(field_id) {
    var url = $('#' + field_id).val();
    // alert('yo'); 
    $('#' + field_id).next().next().attr('src', url);
    $('#' + field_id).next().next().show();
}
</script>