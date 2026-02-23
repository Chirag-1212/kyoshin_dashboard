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
                                    <label>Sunday-Thursday<span>*</span></label>
                                    <input type="text" name="sunday_to_thursday_hour" class="form-control"
                                        id="sunday_to_thursday_hour" placeholder="Sunday-Thursday"
                                        value="<?php echo (((isset($detail->sunday_to_thursday_hour)) && $detail->sunday_to_thursday_hour != '')? $detail->sunday_to_thursday_hour : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sunday-Thursday Nepali</label>
                                    <input type="text" name="sunday_to_thursday_nepali_hour" class="form-control"
                                        id="sunday_to_thursday_nepali_hour" placeholder="Sunday-Thursday Nepali"
                                        value="<?php echo (((isset($detail->sunday_to_thursday_nepali_hour)) && $detail->sunday_to_thursday_nepali_hour != '')? $detail->sunday_to_thursday_nepali_hour : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Friday<span>*</span></label>
                                    <input type="text" name="friday_hour" class="form-control" id="friday_hour"
                                        placeholder="Friday"
                                        value="<?php echo (((isset($detail->friday_hour)) && $detail->friday_hour != '')? $detail->friday_hour : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Friday Nepali</label>
                                    <input type="text" name="friday_nepali_hour" class="form-control"
                                        id="friday_nepali_hour" placeholder="Friday Nepali"
                                        value="<?php echo (((isset($detail->friday_nepali_hour)) && $detail->friday_nepali_hour != '')? $detail->friday_nepali_hour : '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">

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