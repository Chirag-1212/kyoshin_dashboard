<style>
.SUB_BTN .btn {
    width: 90px;
    height: 35px;
    font-size: 15px;
}
</style>


<section class="content">
    <div class="container-fluid">
        <!--<h2 class="text-center display-4">Search</h2>-->
        <form action="<?php echo base_url('team/admin/search'); ?> " method="post">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="Title" class="form-control" placeholder="Title" value="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Designation</label>
                        <select name="designation" class="form-control select2" id="designation">
                            <option value>Select Designation</option>
                            <?php foreach ($designations as $key => $value) { ?>
                            <option value="<?php echo $value->id ?>"
                                <?php echo (((isset($detail->designation)) && $detail->designation == $value->id) ? 'selected' : '') ?>>
                                <?php echo $value->designation_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Team Group</label>
                        <select name="team_group_id" class="form-control select2" id="team_group_id">
                            <option value>Select Group</option>
                            <?php foreach ($groups as $key => $value) { ?>
                            <option value="<?php echo $value->id ?>"
                                <?php echo (((isset($detail->team_group_id)) && $detail->team_group_id == $value->id) ? 'selected' : '') ?>>
                                <?php echo $value->group_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Department</label>
                        <select name="department_id" class="form-control select2" id="department_id">
                            <option value>Select Department</option>
                            <?php foreach ($departs as $key => $value) { ?>
                            <option value="<?php echo $value->id ?>"
                                <?php echo (((isset($detail->department_id)) && $detail->department_id == $value->id) ? 'selected' : '') ?>>
                                <?php echo $value->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2" id="type">
                            <option value="1">Active</option>
                            <option value="0">Enable</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit"
                            value=" search"> </div>
                </div>
            </div>
        </form>
    </div>
</section>