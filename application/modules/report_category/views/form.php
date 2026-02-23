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
                                    <label>Title <span>*</span></label>
                                    <input type="text" name="PageTitle" class="form-control" id="PageTitle"
                                        placeholder="PageTitle"
                                        value="<?php echo (((isset($detail->PageTitle)) && $detail->PageTitle != '') ? $detail->PageTitle : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title Nepali</label>
                                    <input type="text" name="PageTitleNepali" class="form-control" id="PageTitleNepali"
                                        placeholder="PageTitleNepali"
                                        value="<?php echo (((isset($detail->PageTitleNepali)) && $detail->PageTitleNepali != '') ? $detail->PageTitleNepali : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Parent</label>
                                    <select name="parent_id" class="form-control select2" id="parent_id">
                                        <?php echo $html; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" name="featured_image" class="form-control" id="featured_image"
                                        placeholder="featured_image"
                                        value="<?php echo (((isset($detail->CoverImage)) && $detail->CoverImage != '') ? $detail->CoverImage : '') ?>"
                                        readonly="readonly">
                                    <?php if ((isset($detail->CoverImage)) && $detail->CoverImage != '') { ?>
                                    <img src="<?php echo base_url().$detail->CoverImage; ?>" class="img_cl" id="defff0">
                                    <?php } else { ?>
                                    <img src="" class="img_cl" id="defff0" style="display:none">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5"
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
                                <label>Report Type</label>
                                <select name="type" class="form-control select2" id="type">
                                    <option value="" <?php echo (((isset($detail->Type)) && $detail->Type == '') ? 'selected' : '') 
                                                    ?>>Select Report Type</option>
                                  <option value="Report" <?php echo (((isset($detail->Type)) && $detail->Type == 'Report') ? 'selected' : '') 
                                                    ?>>Report</option>
                                  <option value="Disclosure" <?php echo (((isset($detail->Type)) && $detail->Type == 'Disclosure') ? 'selected' : '') 
                                                    ?>>Disclosure</option>
                                </select>
                              </div>
                            </div> 
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Show on Menu</label>
                                <select name="show_on_menu" class="form-control select2" id="show_on_menu">
                                  <option value="Yes" <?php echo (((isset($detail->show_on_menu)) && $detail->show_on_menu == 'Yes') ? 'selected' : '') 
                                                    ?>>Yes</option>
                                  <option value="No" <?php echo (((isset($detail->show_on_menu)) && $detail->show_on_menu == 'No') ? 'selected' : '') 
                                                    ?>>No</option>
                                </select>
                              </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" name="rank" class="form-control" id="rank"
                                        placeholder="Order Number"
                                        value="<?php echo (((isset($detail->rank)) && $detail->rank != '') ? $detail->rank : 0) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control select2" id="status">
                                  <option value="1" <?php echo (((isset($detail->status)) && $detail->status == '1') ? 'selected' : '') 
                                                    ?>>Active</option>
                                  <option value="0" <?php echo (((isset($detail->status)) && $detail->status == '0') ? 'selected' : '') 
                                                    ?>>Inactive</option>
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