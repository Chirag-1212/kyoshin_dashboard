<div class="searchboxx" style="display:none; margin-bottom: 15px;">
    <form action="" method="get">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Search Title</label>
                            <input type="text" name="Title" class="form-control" placeholder="Course Name..." value="<?php echo $this->input->get('Title'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="1" <?php echo ($this->input->get('status') == '1') ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo ($this->input->get('status') == '0') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <input class="btn btn-primary" type="submit" value="Search">
                            <a href="<?php echo base_url($redirect.'/admin/all'); ?>" class="btn btn-default">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Logic to show/hide the search box if you have a search button
$(document).ready(function(){
    $(".search_icons").click(function(){
        $(".searchboxx").slideToggle();
    });
});
</script>