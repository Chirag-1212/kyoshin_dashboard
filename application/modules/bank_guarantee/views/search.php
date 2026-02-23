<style>
.SUB_BTN .btn {
    width: 90px;
    height: 35px;
    font-size: 15px;
}
</style>


<section class="content">
    <div class="container-fluid">
        <form action="<?php echo base_url('bank_guarantee/admin/search'); ?> " method="post">
            
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
                        <label>Beneficiary Name</label>
                        <input type="text" name="beneficiary_name" class="form-control" placeholder="Beneficiary Name" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Created On</label>
                        <input type="date" name="created_on" class="form-control" placeholder="Created Date" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Branch</label>
                        <select name="issued_branch" class="form-control select2" id="issued_branch">
                            <option value>Select Branch</option>
                            <?php  foreach ($branches as $key => $value) { ?>
                            <option value="<?php echo $value->id ?>"
                                <?php echo (((isset($detail->issued_branch)) && $detail->issued_branch == $value->id) ? 'selected' : '') ?>>
                                <?php echo $value->PageTitle; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
			</div>
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Reference Number</label>
                        <select name="reference_number" class="form-control select2" id="reference_number">
                            <option value>Select Reference Number</option>
                            <?php  foreach ($reference_numbers as $key => $value) { ?>
                            <option value="<?php echo $value->reference_number ?>"
                                <?php echo (((isset($detail->reference_number)) && $detail->reference_number == $value->reference_number) ? 'selected' : '') ?>>
                                <?php echo $value->reference_number; ?></option>
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
            </div>
                
                
            <div class="col-sm-12">
                <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit"
                        value=" search"> 
                </div>
            </div>
           
        </form>
    </div>
</section>