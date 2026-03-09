<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <form role="form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo @$detail->id; ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>title (english)</label>
                        <input type="text" name="title" class="form-control" value="<?php echo @$detail->title; ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>title (japanese)</label>
                        <input type="text" name="title_nepali" class="form-control" value="<?php echo @$detail->title_nepali; ?>">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">-- select category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat->id; ?>" <?php echo (@$detail->category_id == $cat->id) ? 'selected' : ''; ?>>
                                    <?php echo $cat->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>sub-topic (heading)</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-control">
                            <option value="">-- select sub-topic --</option>
                            <?php if (!empty($sub_categories)): ?>
                                <?php foreach ($sub_categories as $sub): ?>
                                    <option value="<?php echo $sub->id; ?>" <?php echo (@$detail->sub_category_id == $sub->id) ? 'selected' : ''; ?>>
                                        <?php echo $sub->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>news date</label>
                        <input type="date" name="datevalue" class="form-control" value="<?php echo @$detail->datevalue; ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>due date</label>
                        <input type="date" name="due_date" class="form-control" value="<?php echo @$detail->due_date; ?>">
                    </div>

                    <div class="col-md-3 form-group" style="padding-top: 25px;">
                        <label>
                            <input type="checkbox" name="is_slider" value="1" <?php echo (@$detail->is_slider == '1') ? 'checked' : ''; ?>> show in slider
                        </label>
                    </div>
                    <div class="col-md-3 form-group" style="padding-top: 25px;">
                        <label>
                            <input type="checkbox" name="imp_notice" value="1" <?php echo (@$detail->imp_notice == '1') ? 'checked' : ''; ?>> important notice
                        </label>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>description (english)</label>
                        <textarea name="description" class="form-control editor"><?php echo @$detail->description; ?></textarea>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>main document</label>
                        <input type="file" name="docpath" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>cover image</label>
                        <input type="file" name="coverimage" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?php echo (@$detail->status == '1') ? 'selected' : ''; ?>>active</option>
                            <option value="0" <?php echo (@$detail->status == '0') ? 'selected' : ''; ?>>inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">save news</button>
            </div>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#category_id').change(function() {
        var parent_id = $(this).val();
        if (parent_id != "") {
            $.ajax({
                url: "<?php echo base_url($redirect . '/admin/get_sub_categories'); ?>",
                method: "POST",
                data: { parent_id: parent_id },
                dataType: "JSON",
                success: function(data) {
                    var html = '<option value="">-- select sub-topic --</option>';
                    $.each(data, function(key, val) {
                        html += '<option value="' + val.id + '">' + val.name + '</option>';
                    });
                    $('#sub_category_id').html(html);
                }
            });
        } else {
            $('#sub_category_id').html('<option value="">-- select sub-topic --</option>');
        }
    });
});
</script>