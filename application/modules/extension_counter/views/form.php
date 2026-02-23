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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Title <span class="req">*</span></label>
                                    <input type="text" name="Title" class="form-control" id="Title" placeholder="Title"
                                        value="<?php echo set_value('Title', (((isset($detail->PageTitle)) && $detail->PageTitle != '') ? $detail->PageTitle : '')); ?>"
                                        required>
                                    <?php echo form_error('Title', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Title Nepali</label>
                                    <input type="text" name="TitleNepali" class="form-control" id="TitleNepali"
                                        placeholder="Title Nepali"
                                        value="<?php echo set_value('TitleNepali', (((isset($detail->PageTitleNepali)) && $detail->PageTitleNepali != '') ? $detail->PageTitleNepali : '')); ?>">
                                    <?php echo form_error('TitleNepali', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="Email" class="form-control" id="Email" placeholder="Email"
                                        value="<?php echo set_value('Email', (((isset($detail->Email)) && $detail->Email != '') ? $detail->Email : '')); ?>">
                                    <?php echo form_error('Email', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select District</label>
                                    <select name="district_id" class="form-control select2" id="district_id">
                                        <option value>Select District</option>
                                        <?php foreach ($districts as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->district_id)) && $detail->district_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="Address" class="form-control" id="Address"
                                        placeholder="Address"
                                        value="<?php echo set_value('Address', (((isset($detail->Address)) && $detail->Address != '') ? $detail->Address : '')); ?>">
                                    <?php echo form_error('Address', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Address Nepali</label>
                                    <input type="text" name="AddressNepali" class="form-control" id="AddressNepali"
                                        placeholder="Address Nepali"
                                        value="<?php echo set_value('AddressNepali', (((isset($detail->AddressNepali)) && $detail->AddressNepali != '') ? $detail->AddressNepali : '')); ?>">
                                    <?php echo form_error('AddressNepali', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        placeholder="Mobile"
                                        value="<?php echo set_value('mobile', (((isset($detail->mobile)) && $detail->mobile != '') ? $detail->mobile : '')); ?>">
                                    <?php echo form_error('mobile', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mobile Nepali</label>
                                    <input type="text" name="mobile_nepali" class="form-control" id="mobile_nepali"
                                        placeholder="Mobile Nepali"
                                        value="<?php echo set_value('mobile_nepali', (((isset($detail->mobile_nepali)) && $detail->mobile_nepali != '') ? $detail->mobile_nepali : '')); ?>">
                                    <?php echo form_error('mobile_nepali', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="Phone" class="form-control" id="Phone" placeholder="Phone"
                                        value="<?php echo set_value('Phone', (((isset($detail->Phone)) && $detail->Phone != '') ? $detail->Phone : '')); ?>">
                                    <?php echo form_error('Phone', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Phone Nepali</label>
                                    <input type="text" name="PhoneNepali" class="form-control" id="PhoneNepali"
                                        placeholder="Phone Nepali"
                                        value="<?php echo set_value('PhoneNepali', (((isset($detail->PhoneNepali)) && $detail->PhoneNepali != '') ? $detail->PhoneNepali : '')); ?>">
                                    <?php echo form_error('PhoneNepali', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="number" step=".0000000001" name="latitude" class="form-control"
                                        id="latitude" placeholder="Latitude"
                                        value="<?php echo set_value('latitude', (((isset($detail->latitude)) && $detail->latitude != '') ? $detail->latitude : '')); ?>">
                                    <?php echo form_error('latitude', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="number" step=".0000000001" name="longitude" class="form-control"
                                        id="longitude" placeholder="Longitude"
                                        value="<?php echo set_value('longitude', (((isset($detail->longitude)) && $detail->longitude != '') ? $detail->longitude : '')); ?>">
                                    <?php echo form_error('longitude', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="border: 1px solid #ddd;border-radius: 5px;">
                                <p style="font-size: 17px; font-weight: bold;border-bottom: 1px solid #ddd;">Entry About
                                    Personal</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="BMName" class="form-control" id="BMName"
                                                placeholder="Name"
                                                value="<?php echo set_value('BMName', (((isset($detail->Manager)) && $detail->Manager != '') ? $detail->Manager : '')); ?>">
                                            <?php echo form_error('BMName', '<div class="error_message">', '</div>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name Nepali</label>
                                            <input type="text" name="BMNameNepali" class="form-control"
                                                id="BMNameNepali" placeholder="Name Nepali"
                                                value="<?php echo set_value('BMNameNepali', (((isset($detail->ManagerNepali)) && $detail->ManagerNepali != '') ? $detail->ManagerNepali : '')); ?>">
                                            <?php echo form_error('BMNameNepali', '<div class="error_message">', '</div>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serial</label>
                                    <input type="number" name="Serial" class="form-control" id="Serial"
                                        placeholder="Name"
                                        value="<?php echo set_value('Serial', (((isset($detail->Serial)) && $detail->Serial != '') ? $detail->Serial : '')); ?>">
                                    <?php echo form_error('Serial', '<div class="error_message">', '</div>'); ?>
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