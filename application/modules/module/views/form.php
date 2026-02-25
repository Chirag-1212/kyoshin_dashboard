<style>
  span.rmv_btn_mdl {
    /* float: right; */
    background: red;
    border-radius: 50%;
    padding: 1px 0px 0px 8px;
    width: 25px;
    height: 25px;
    font-size: 17px;
    color: #fff;
    font-weight: bold;
    position: absolute;
    right: -2px;
    top: 0;
  }

  .rmv_modle {
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 15px;
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Module Name<span class="req">*</span></label>
                                    <input type="text" name="module_name" class="form-control" id="module_name"
                                        placeholder="Module Name"
                                        value="<?php echo set_value('module_name', (((isset($detail->module_name)) && $detail->module_name != '') ? $detail->module_name : '')); ?>"
                                        <?php echo (((isset($detail->module_name)) && $detail->module_name != '') ? 'readonly' : ''); ?>>
                                    <?php echo form_error('module_name', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Module Display Name<span class="req">*</span></label>
                                    <input type="text" name="display_name" class="form-control" id="display_name"
                                        placeholder="Display Name"
                                        value="<?php echo set_value('display_name', (((isset($detail->display_name)) && $detail->display_name != '') ? $detail->display_name : '')); ?>">
                                    <?php echo form_error('display_name', '<div class="error_message">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Menu *</label>
                                <select name="menu_id" class="form-control select2">
                                    <option value="">Select Menu</option>
                                    <?php foreach ($menus as $menu) { ?>
                                        <option value="<?php echo $menu->id; ?>"
                                        <?php echo (isset($detail->menu_id) && $detail->menu_id == $menu->id) ? 'selected' : ''; ?>>
                                            <?php echo $menu->menu; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Icon</label>
                                <input type="text" name="icon" class="form-control"
                                    placeholder="fas fa-users"
                                    value="<?php echo set_value('icon', $detail->icon ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="1"
                                            <?php echo  set_select('status', '1', (isset($detail->status) && $detail->status == '1') ? TRUE : ''); ?>>
                                            Enable</option>
                                        <option value="0"
                                            <?php echo  set_select('status', '0', (isset($detail->status) && $detail->status == '0') ? TRUE : ''); ?>>
                                            Dissable</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a class="btn btn-sm btn-info" id="add_function">Click To Add Functions</a>
                                </div>
                            </div>
                        </div>
                        <div class="functions" style="border: 1px solid #ddd; padding: 10px;margin-bottom: 20px;">
                            <div class="row" id="apnd_funct">

                                <?php
                                if (isset($detail->id)) {
                                  $childs = $this->crud_model->get_where('module_function', array('module_id' => $detail->id));
                                  if ($childs) {
                                    foreach ($childs as $key => $val) {
                                ?>
                                <div class="col-md-4 rmv_modle">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Function name<span class="req">*</span></label>
                                                <input type="text" name="function_name[]" class="form-control"
                                                    placeholder="Function Name"
                                                    value="<?php echo (((isset($val->function_name)) && $val->function_name != '') ? $val->function_name : ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Display name<span class="req">*</span></label>
                                                <input type="text" name="display_name_function[]" class="form-control"
                                                    placeholder="Display Name"
                                                    value="<?php echo (((isset($val->display_name)) && $val->display_name != '') ? $val->display_name : ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <span class="rmv_btn_mdl rmv_functns">X</span>
                                </div>
                                <?php
                                }
                              }
                            }
                            ?>
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
