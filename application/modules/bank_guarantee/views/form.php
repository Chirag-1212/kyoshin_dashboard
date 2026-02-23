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
                                    <label>Branch<span>*</span></label>
                                    <select name="issued_branch" class="form-control select2" id="issued_branch" required>
                                        <option value>Select Branch</option>
                                        <?php foreach ($branches as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->issued_branch)) && $detail->issued_branch == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->PageTitle; ?></option>
                                        <?php } ?>
                                    </select>
                                    
									
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference Number<span>*</span></label>
									<input type="text" name="reference_number" class="form-control" id="reference_number" placeholder="Reference Number" value="<?php echo (((isset($detail->reference_number)) && $detail->reference_number != '')? $detail->reference_number : '') ?>" required>
                        
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Applicant Name <span>*</span></label>
									<input type="text" name="applicant_name" class="form-control" id="applicant_name" placeholder="Applicant Name" value="<?php echo (((isset($detail->applicant_name)) && $detail->applicant_name != '')? $detail->applicant_name : '') ?>" required>
                    
                                </div>
                            </div>
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Beneficiary Name <span>*</span></label>
									<input type="text" name="beneficiary_name" class="form-control" id="beneficiary_name" placeholder="Beneficiary Name" value="<?php echo (((isset($detail->beneficiary_name)) && $detail->beneficiary_name != '')? $detail->beneficiary_name : '') ?>" required>
                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address<span>*</span></label>
									<input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php echo (((isset($detail->address)) && $detail->address != '')? $detail->address : '') ?>" required>
                    
                                </div>
                            </div>
                             
                        </div>
                         <div class="row">
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Issued Date <span>*</span></label>
									<input type="date" name="issue_date" class="form-control" id="issue_date" placeholder="Issued Date" value="<?php echo (((isset($detail->issue_date)) && $detail->issue_date != '')? $detail->issue_date : '') ?>" required>
								</div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Value Date<span>*</span></label>
									<input type="date" name="value_date" class="form-control" id="value_date" placeholder="Value Date" value="<?php echo (((isset($detail->value_date)) && $detail->value_date != '')? $detail->value_date : '') ?>" required>
								
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Expiry Date<span>*</span></label>
									<input type="date" name="expiry_date" class="form-control" id="expiry_date" placeholder="Expiry Date" value="<?php echo (((isset($detail->expiry_date)) && $detail->expiry_date != '')? $detail->expiry_date : '') ?>" required>
                    
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Currency<span>*</span></label>
                                    <select name="currency_id" class="form-control select2" id="currency_id" required>
                                        <option value>Select Currency</option>
                                        <?php foreach ($currencies as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>"
                                            <?php echo (((isset($detail->currency_id)) && $detail->currency_id == $value->id) ? 'selected' : '') ?>>
                                            <?php echo $value->symbol; ?></option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                           
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount<span>*</span></label>
									<input type="number" step="any" name="amount" class="form-control" id="amount" placeholder="Amount" value="<?php echo (((isset($detail->amount)) && $detail->amount != '')? $detail->amount : '') ?>" required>
                        
                                </div>
                            </div>
                        </div>
                       
                       
                        <div class="row">

                            <div class="col-md-4">
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
                                    <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Save">  
									<input type="hidden" name="id" class="form-control btn btn-sm btn-primary" id="submit" value="<?php echo (((isset($detail->id)) && $detail->id != '')? $detail->id : '') ?>">  
                   
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