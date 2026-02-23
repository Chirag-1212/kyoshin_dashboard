<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title ?></h3>
            </div>
            <form class="all_form" method="post" action enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Site Name</label>
                                <input type="text" name="site_name" class="form-control" id="site_name"
                                    placeholder="Site Name"
                                    value="<?php echo (((isset($site_settings->site_name)) && $site_settings->site_name != '') ? $site_settings->site_name : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Site Short Name</label>
                                <input type="text" name="short_name" class="form-control" id="short_name"
                                    placeholder="Site Name"
                                    value="<?php echo (((isset($site_settings->short_name)) && $site_settings->short_name != '') ? $site_settings->short_name : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Site Slogan</label>
                                    <input type="text" name="site_slogan" class="form-control" id="site_slogan"
                                        placeholder="Site Slogan"
                                        value="<?php echo (((isset($site_settings->site_slogan)) && $site_settings->site_slogan != '') ? $site_settings->site_slogan : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Website Url</label>
                                <input type="text" name="web_url" class="form-control" id="web_url"
                                    placeholder="Web Url"
                                    value="<?php echo (((isset($site_settings->web_url)) && $site_settings->web_url != '') ? $site_settings->web_url : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Address"
                                    value="<?php echo (((isset($site_settings->address)) && $site_settings->address != '') ? $site_settings->address : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        placeholder="Mobile"
                                        value="<?php echo (((isset($site_settings->mobile)) && $site_settings->mobile != '') ? $site_settings->mobile : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Telephone</label>
                                    <input type="text" name="telephone" class="form-control" id="telephone"
                                        placeholder="Telephone"
                                        value="<?php echo (((isset($site_settings->telephone)) && $site_settings->telephone != '') ? $site_settings->telephone : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address In Nepali</label>
                                <input type="text" name="address_np" class="form-control" id="address_np"
                                    placeholder="Address In Nepali"
                                    value="<?php echo (((isset($site_settings->address_np)) && $site_settings->address_np != '') ? $site_settings->address_np : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Mobile In Nepali</label>
                                    <input type="text" name="mobile_np" class="form-control" id="mobile_np"
                                        placeholder="Mobile In Nepali"
                                        value="<?php echo (((isset($site_settings->mobile_np)) && $site_settings->mobile_np != '') ? $site_settings->mobile_np : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Telephone In Nepali</label>
                                    <input type="text" name="telephone_np" class="form-control" id="telephone_np"
                                        placeholder="Telephone In Nepali"
                                        value="<?php echo (((isset($site_settings->telephone_np)) && $site_settings->telephone_np != '') ? $site_settings->telephone_np : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                  <label>Map Location</label>
                                <input type="text" name="map_location" class="form-control" id="map_location"
                                        placeholder="Enter Map Location"
                                        value="<?php echo (((isset($site_settings->map_location)) && $site_settings->map_location != '') ? $site_settings->map_location : '') ?>">
                               </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contact Details</label>
                                <textarea name="contact_detail" id="content2" class="form-control" rows="5" cols="80"
                                    autocomplete="off"><?php echo (((isset($site_settings->contact_detail)) && $site_settings->contact_detail != '') ? $site_settings->contact_detail : '') ?></textarea>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

                <div class="box-header with-border">
                    <h3 class="box-title">Social</h3>
                </div>
                <!-- /.card-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email"
                                    value="<?php echo (((isset($site_settings->email)) && $site_settings->email != '') ? $site_settings->email : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" name="facebook" class="form-control" id="facebook"
                                    placeholder="Facebook"
                                    value="<?php echo (((isset($site_settings->facebook)) && $site_settings->facebook != '') ? $site_settings->facebook : '') ?>">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" id="whatsapp"
                                    placeholder="Whatsapp"
                                    value="<?php echo (((isset($site_settings->whatsapp)) && $site_settings->whatsapp != '') ? $site_settings->whatsapp : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Skype</label>
                                <input type="text" name="skype" class="form-control" id="skype" placeholder="Skype"
                                    value="<?php echo (((isset($site_settings->skype)) && $site_settings->skype != '') ? $site_settings->skype : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Twitter</label>
                                <input type="text" name="twitter" class="form-control" id="twitter"
                                    placeholder="Twitter"
                                    value="<?php echo (((isset($site_settings->twitter)) && $site_settings->twitter != '') ? $site_settings->twitter : '') ?>">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="instagram"
                                        placeholder="Instagram"
                                        value="<?php echo (((isset($site_settings->instagram)) && $site_settings->instagram != '') ? $site_settings->instagram : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" name="youtube" class="form-control" id="youtube"
                                    placeholder="Youtube"
                                    value="<?php echo (((isset($site_settings->youtube)) && $site_settings->youtube != '') ? $site_settings->youtube : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Google+</label>
                                <input type="text" name="googleplus" class="form-control" id="googlepluss"
                                    placeholder="Googleplus"
                                    value="<?php echo (((isset($site_settings->googleplus)) && $site_settings->googleplus != '') ? $site_settings->googleplus : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linked In</label>
                                <input type="text" name="linked_in" class="form-control" id="linked_in"
                                    placeholder="Linked In"
                                    value="<?php echo (((isset($site_settings->linked_in)) && $site_settings->linked_in != '') ? $site_settings->linked_in : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Viber</label>
                                <input type="text" name="viber" class="form-control" id="viber" placeholder="Viber Link"
                                    value="<?php echo (((isset($site_settings->viber)) && $site_settings->viber != '') ? $site_settings->viber : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>App Store</label>
                                <input type="text" name="app_store" class="form-control" id="app_store"
                                    placeholder="App Store Link"
                                    value="<?php echo (((isset($site_settings->app_store)) && $site_settings->app_store != '') ? $site_settings->app_store : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Google Play</label>
                                <input type="text" name="google_play" class="form-control" id="google_play"
                                    placeholder="Google Play"
                                    value="<?php echo (((isset($site_settings->google_play)) && $site_settings->google_play != '') ? $site_settings->google_play : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Banking Hour</h3>
                </div>

                <!-- /.card-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Opening Time</label>
                                <input type="time" name="opening_time" class="form-control" id="opening_time"
                                    placeholder="Opening Time"
                                    value="<?php echo (((isset($site_settings->opening_time)) && $site_settings->opening_time != '') ? $site_settings->opening_time : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Closing Time</label>
                                <input type="time" name="closing_time" class="form-control" id="closing_time"
                                    placeholder="Closing Time"
                                    value="<?php echo (((isset($site_settings->closing_time)) && $site_settings->closing_time != '') ? $site_settings->closing_time : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Opening Time for Friday</label>
                                <input type="time" name="opening_time_friday" class="form-control"
                                    id="opening_time_friday" placeholder="Opening Time Friday"
                                    value="<?php echo (((isset($site_settings->opening_time_friday)) && $site_settings->opening_time_friday != '') ? $site_settings->opening_time_friday : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Closing Time for Friday</label>
                                <input type="time" name="closing_time_friday" class="form-control"
                                    id="closing_time_friday" placeholder="Closing Time Friday"
                                    value="<?php echo (((isset($site_settings->closing_time_friday)) && $site_settings->closing_time_friday != '') ? $site_settings->closing_time_friday : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Opening Time for Holiday</label>
                                <input type="time" name="holiday_opening" class="form-control"
                                    id="holiday_opening" placeholder="Opening Time Friday"
                                    value="<?php echo (((isset($site_settings->holiday_opening)) && $site_settings->holiday_opening != '') ? $site_settings->holiday_opening : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Closing Time for Holiday</label>
                                <input type="time" name="holiday_closing" class="form-control"
                                    id="holiday_closing" placeholder="Closing Time Friday"
                                    value="<?php echo (((isset($site_settings->holiday_closing)) && $site_settings->holiday_closing != '') ? $site_settings->holiday_closing : '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Digital Help Desk Support Team</h3>
                </div>

                <!-- /.card-header -->
                <div class="box-body">
                    <div class="row">
                         <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input type="text" name="help_team" class="form-control" id="help_team"
                                        placeholder="Contact Person"
                                        value="<?php echo (((isset($site_settings->help_team)) && $site_settings->help_team != '') ? $site_settings->help_team : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="help_email" class="form-control" id="help_email"
                                        placeholder="Contact Person"
                                        value="<?php echo (((isset($site_settings->help_email)) && $site_settings->help_email != '') ? $site_settings->help_email : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address/Department</label>
                                <input type="text" name="help_address" class="form-control" id="help_address"
                                    placeholder="Address/Department"
                                    value="<?php echo (((isset($site_settings->help_address)) && $site_settings->help_address != '') ? $site_settings->help_address : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="help_mobile" class="form-control" id="help_mobile"
                                        placeholder="Mobile"
                                        value="<?php echo (((isset($site_settings->help_mobile)) && $site_settings->help_mobile != '') ? $site_settings->help_mobile : '') ?>">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Telephone</label>
                                    <input type="text" name="help_telephone" class="form-control" id="help_telephone"
                                        placeholder="Telephone"
                                        value="<?php echo (((isset($site_settings->help_telephone)) && $site_settings->help_telephone != '') ? $site_settings->help_telephone : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Extension no.</label>
                                    <input type="text" name="help_ext" class="form-control" id="help_ext"
                                        placeholder="Extension no."
                                        value="<?php echo (((isset($site_settings->help_ext)) && $site_settings->help_ext != '') ? $site_settings->help_ext : '') ?>">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                         <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Contact Person In Nepali</label>
                                    <input type="text" name="help_team_np" class="form-control" id="help_team_np"
                                        placeholder="Contact Person"
                                        value="<?php echo (((isset($site_settings->help_team_np)) && $site_settings->help_team_np != '') ? $site_settings->help_team_np : '') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address/Department In Nepali</label>
                                <input type="text" name="help_address_np" class="form-control" id="help_address_np"
                                    placeholder="Address/Department"
                                    value="<?php echo (((isset($site_settings->help_address_np)) && $site_settings->help_address_np != '') ? $site_settings->help_address_np : '') ?>">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Mobile In Nepali</label>
                                    <input type="text" name="help_mobile_np" class="form-control" id="help_mobile_np"
                                        placeholder="Mobile"
                                        value="<?php echo (((isset($site_settings->help_mobile_np)) && $site_settings->help_mobile_np != '') ? $site_settings->help_mobile_np : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Telephone In Nepali</label>
                                    <input type="text" name="help_telephone_np" class="form-control" id="help_telephone_np"
                                        placeholder="Telephone"
                                        value="<?php echo (((isset($site_settings->help_telephone_np)) && $site_settings->help_telephone_np != '') ? $site_settings->help_telephone_np : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Extension no. In Nepali</label>
                                    <input type="text" name="help_ext_np" class="form-control" id="help_ext_np"
                                        placeholder="Extension no."
                                        value="<?php echo (((isset($site_settings->help_ext_np)) && $site_settings->help_ext_np != '') ? $site_settings->help_ext_np : '') ?>">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Images</h3>
                </div>

                <!-- /.card-header -->
                <div class="box-body">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" name="logo" class="form-control" id="logo"
                                        placeholder="File" value="<?php echo (((isset($site_settings->logo)) && $site_settings->logo != '') ? $site_settings->logo : '') ?>">
                                  
                                    <?php if ((isset($site_settings->logo)) && $site_settings->logo != '') { ?>
                                    <img src="<?php echo base_url().$site_settings->logo; ?>" class="img_cl" id="defff0"
                                        style="max-width: 100%;">
                                    <?php } else { ?>
                                    <img src="" class="img_cl" id="defff0" style="display:none; max-width: 100%;">
                                    <?php } ?>

                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fav Icon</label>
                                    <input type="file" name="fav" class="form-control" id="fav" placeholder="Fav"
                                        value="<?php echo (((isset($site_settings->fav)) && $site_settings->fav != '') ? $site_settings->fav : '') ?>"
                                        readonly="readonly">
                                     <?php if ((isset($site_settings->fav)) && $site_settings->fav != '') { ?>
                                    <img src="<?php echo base_url().$site_settings->fav; ?>" class="img_cl" id="defff0"
                                        style="max-width: 100%;">
                                    <?php } else { ?>
                                    <img src="" class="img_cl" id="defff0" style="display:none;max-width: 100%;">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Default Image</label>
                                    <input type="file" name="default_img" class="form-control" id="default_img"
                                        placeholder="Default Image"
                                        value="<?php echo (((isset($site_settings->default_img)) && $site_settings->default_img != '') ? $site_settings->default_img : '') ?>"
                                        readonly="readonly">
                                    <?php if ((isset($site_settings->default_img)) && $site_settings->default_img != '') { ?>
                                    <img src="<?php echo base_url().$site_settings->default_img; ?>" class="img_cl" id="defff0"
                                        style="max-width: 100%;">
                                    <?php } else { ?>
                                    <img src="" class="img_cl" id="defff0" style="display:none;max-width: 100%;">
                                    <?php } ?>

                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title">Meta Settings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" id="meta_title"
                                        placeholder="Meta Title"
                                        value="<?php echo (((isset($site_settings->meta_title)) && $site_settings->meta_title != '') ? $site_settings->meta_title : '') ?>">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" id="content3" class="form-control" rows="5" cols="80"
                                        autocomplete="off"><?php echo (((isset($site_settings->meta_description)) && $site_settings->meta_description != '') ? $site_settings->meta_description : '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_key_words" class="form-control" id="meta_key_words"
                                        placeholder="Meta Keywords"
                                        value="<?php echo (((isset($site_settings->meta_key_words)) && $site_settings->meta_key_words != '') ? $site_settings->meta_key_words : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary"
                                        id="submit" value="Save">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function responsive_filemanager_callback(field_id) {
    var url = $('#' + field_id).val();
    // alert('yo'); 
    $('#' + field_id).next().next().attr('src', url);
    $('#' + field_id).next().next().show();
}
</script>