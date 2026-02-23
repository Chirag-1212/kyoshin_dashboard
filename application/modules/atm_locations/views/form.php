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
                                    <label>Title <span>*</span></label>
                                    <input type="text" name="PageTitle" class="form-control" id="PageTitle"
                                        placeholder="PageTitle"
                                        value="<?php echo (((isset($detail->PageTitle)) && $detail->PageTitle != '') ? $detail->PageTitle : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title Nepali</label>
                                    <input type="text" name="PageTitleNepali" class="form-control" id="PageTitleNepali"
                                        placeholder="Title Nepali"
                                        value="<?php echo (((isset($detail->PageTitleNepali)) && $detail->PageTitleNepali != '') ? $detail->PageTitleNepali : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="Address" class="form-control" id="Address"
                                        placeholder="Address"
                                        value="<?php echo (((isset($detail->Address)) && $detail->Address != '') ? $detail->Address : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address Nepali</label>
                                    <input type="text" name="AddressNepali" class="form-control" id="AddressNepali"
                                        placeholder="Address Nepali"
                                        value="<?php echo (((isset($detail->AddressNepali)) && $detail->AddressNepali != '') ? $detail->AddressNepali : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control" id="contact"
                                        placeholder="Contact"
                                        value="<?php echo (((isset($detail->contact)) && $detail->contact != '') ? $detail->contact : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contact Nepali</label>
                                    <input type="text" name="contact_nepali" class="form-control" id="contact_nepali"
                                        placeholder="Contact Nepali"
                                        value="<?php echo (((isset($detail->contact_nepali)) && $detail->contact_nepali != '') ? $detail->contact_nepali : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Map Link</label>
                                    <input type="text" name="map_link" class="form-control" id="map_link"
                                        placeholder="Contact Nepali"
                                        value="<?php echo (((isset($detail->map_link)) && $detail->map_link != '') ? $detail->map_link : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Google plus code</label>
                                    <input type="text" name="google_plus" class="form-control" id="google_plus"
                                        placeholder="Contact Nepali"
                                        value="<?php echo (((isset($detail->google_plus)) && $detail->google_plus != '') ? $detail->google_plus : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" step=".0000000001" name="latitude" class="form-control"
                                        id="latitude" placeholder="Latitude"
                                        value="<?php echo (((isset($detail->latitude)) && $detail->latitude != '') ? $detail->latitude : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" step=".0000000001" name="longitude" class="form-control"
                                        id="longitude" placeholder="Longitude"
                                        value="<?php echo (((isset($detail->longitude)) && $detail->longitude != '') ? $detail->longitude : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="Location" class="form-control select2" id="Location">
                                        <option value="inside"
                                            <?php echo (((isset($detail->Location)) && $detail->Location == 'inside') ? 'selected' : '') ?>>
                                            Inside Valley</option>
                                        <option value="outside"
                                            <?php echo (((isset($detail->Location)) && $detail->Location == 'outside') ? 'selected' : '') ?>>
                                            Outside Valley</option>
                                    </select>
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
                                    <textarea name="description_nepali" id="DescriptionNepali" class="form-control"
                                        rows="5" cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->description_nepali)) && $detail->description_nepali != '') ? $detail->description_nepali : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Serial</label>
                                    <input type="number" name="Serial" class="form-control" id="Serial"
                                        placeholder="Name"
                                        value="<?php echo set_value('Serial', (((isset($detail->Serial)) && $detail->Serial != '') ? $detail->Serial : '')); ?>">
                                    <?php echo form_error('Serial', '<div class="error_message">', '</div>'); ?>
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
<script>
function responsive_filemanager_callback(field_id) {
    var url = $('#' + field_id).val();
    // alert('yo'); 
    $('#' + field_id).next().next().attr('src', url);
    $('#' + field_id).next().next().show();
}
</script>