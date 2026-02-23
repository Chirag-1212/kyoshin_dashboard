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
                                        placeholder="Full Name"
                                        value="<?php echo (((isset($detail->name)) && $detail->name != '')? $detail->name : '') ?>">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name Nepali <span>*</span></label>
                                    <input type="text" name="name_nepali" class="form-control" id="name_nepali"
                                        placeholder="Full Name Nepali"
                                        value="<?php echo (((isset($detail->name_nepali)) && $detail->name_nepali != '')? $detail->name_nepali : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control" id="contact"
                                        placeholder="Contact"
                                        value="<?php echo (((isset($detail->contact)) && $detail->contact != '')? $detail->contact : '') ?>">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact In Nepali</label>
                                    <input type="text" name="contact_np" class="form-control" id="contact_np"
                                        placeholder="Contact In Nepali"
                                        value="<?php echo (((isset($detail->contact_np)) && $detail->contact_np != '')? $detail->contact_np : '') ?>">
                                </div>
                            </div>
                        </div>
                         <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" id="address"
                                        placeholder="Address"
                                        value="<?php echo (((isset($detail->address)) && $detail->address != '')? $detail->address : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address In Nepali</label>
                                    <input type="text" name="address_np" class="form-control" id="address_np" placeholder="Address In Nepali"
                                        value="<?php echo (((isset($detail->address_np)) && $detail->address_np != '')? $detail->address_np : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Email"
                                        value="<?php echo (((isset($detail->email)) && $detail->email != '')? $detail->email : '') ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Designation</label>
                                    <select name="designation" class="form-control select2" id="designation">
                                        <option value>Select Designation</option>
                                        <?php foreach ($designations as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->designation)) && $detail->designation == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->designation_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Designation</label>
                                    <input type="text" name="sub_designation" class="form-control" id="sub_designation"
                                        placeholder="Sub Designation"
                                        value="<?php echo (((isset($detail->sub_designation)) && $detail->sub_designation != '')? $detail->sub_designation : '') ?>">
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
                                        id="defff0" style="max-height: 250px;object-fit: contain;">
                                    <?php }else{ ?>
                                    <img src="" class="img_cl img-fluid" id="defff0"
                                        style="display:none;max-height: 250px;object-fit: contain;">
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Team Group</label>
                                    <select name="team_group_id" class="form-control select2" id="team_group_id">
                                        <option value>Select Group</option>
                                        <?php foreach ($groups as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->team_group_id)) && $detail->team_group_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->group_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Department</label>
                                    <select name="department_id" class="form-control select2" id="department_id">
                                        <option value>Select Department</option>
                                        <?php foreach ($departs as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->department_id)) && $detail->department_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->department_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5"
                                        cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->description)) && $detail->description != '')? $detail->description : '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description Nepali</label>
                                    <textarea name="description_nepali" id="DescriptionNepali" class="form-control"
                                        rows="5" cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->description_nepali)) && $detail->description_nepali != '')? $detail->description_nepali : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Order </label>
                                    <input type="number" name="rank" class="form-control" id="rank" placeholder="Order"
                                        value="<?php echo (((isset($detail->rank)) && $detail->rank != '')? $detail->rank : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Block</label></label>
                                    <select name="is_block" class="form-control select2" id="is_block">
                                        <option value="Yes"
                                            <?php echo (((isset($detail->is_block)) && $detail->is_block == 'Yes') ? 'selected' : '') ?>>
                                            Yes</option>
                                        <option value="No"
                                            <?php echo (((isset($detail->is_block)) && $detail->is_block == 'No') ? 'selected' : '') ?>>
                                            No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
</section>
<script>
function responsive_filemanager_callback(field_id) {
    var url = $('#' + field_id).val();
    // alert('yo'); 
    $('#' + field_id).next().next().attr('src', url);
    $('#' + field_id).next().next().show();
}
</script>