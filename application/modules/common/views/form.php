<section class="content">
    <div class="container-fluid">
        <form class="all_form" method="post" action enctype="multipart/form-data">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $title ?></h3>

                    <div class="box-tools">
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
                                <label>Old Password</label>
                                <input type="password" name="old_password" class="form-control" id="old_password"
                                    placeholder="Old Password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_conf" class="form-control" id="password_conf"
                                    placeholder="Confirm Password" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="SUB_BTN">
                                <input type="submit" name="submit" class=" btn btn-sm btn-primary" id="submit"
                                    value="Save">
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