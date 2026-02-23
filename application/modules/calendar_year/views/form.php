<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="all_form" method="post" action enctype="multipart/form-data">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $title ?></h3>

                        <<div class="box-tools pull-right">
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
                                <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                                    value="<?php echo (((isset($detail->title)) && $detail->title != '') ? $detail->title : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title Nepali</label>
                                <input type="text" name="title_nepali" class="form-control" id="title_nepali"
                                    placeholder="Title Nepali"
                                    value="<?php echo (((isset($detail->title_nepali)) && $detail->title_nepali != '') ? $detail->title_nepali : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current</label>
                                <select name="is_current" class="form-control select2" id="is_current">
                                    <option value="No"
                                        <?php echo (((isset($detail->is_current)) && $detail->is_current == 'No') ? 'selected' : '') ?>>
                                        No</option>
                                    <option value="Yes"
                                        <?php echo (((isset($detail->is_current)) && $detail->is_current == 'Yes') ? 'selected' : '') ?>>
                                        Yes</option>
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" name="submit" class="form-control btn btn-sm btn-primary"
                                    id="submit" value="Save">
                                <input type="hidden" name="id" class="form-control btn btn-sm btn-primary" id="submit"
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