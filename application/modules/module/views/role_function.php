<style>
span.rmv_btn_mdl {
    float: right;
    background: red;
    border-radius: 50%;
    padding: 1px 0px 0px 8px;
    width: 25px;
    height: 25px;
    font-size: 17px;
    color: #fff;
    font-weight: bold;
}
</style>
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
                                    <label>Select Role</label>
                                    <select name="role_id" class="form-control select2" id="role_id">
                                        <?php
                                    foreach ($role as $key => $val) {
                                    ?>
                                        <option value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="functions" style="border: 1px solid #ddd; padding: 10px;margin-bottom: 20px;"
                            id="append_persmission">

                            <?php
                        foreach ($module as $key => $val) {
                            $module_function =  $this->crud_model->get_where('module_function', array('module_id' => $val->id));
                        ?>
                            <div class=" row">
                                <div class="col-md-12">
                                    <label><?php echo $val->display_name; ?></label>
                                </div>

                                <?php foreach ($module_function as $key_f => $val_f) { ?>
                                <div class="col-md-3">
                                    <input type="checkbox" name="module_function_id[]" value="<?php echo $val_f->id; ?>"
                                        style="margin-right: 10px;" <?php foreach ($module_function_role as $key_fr => $val_fr) {
                                            if ($val_fr->module_function_id == $val_f->id) {
                                                echo "checked";
                                            }
                                        } ?>><?php echo $val_f->display_name ?>
                                </div>
                                <?php } ?>

                            </div>
                            <?php
                        }
                        ?>
                        </div>
                        <div class="row">
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
</section>