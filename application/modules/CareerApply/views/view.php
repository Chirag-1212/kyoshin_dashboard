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
                        <h3>Personal Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Career Applied :</label> <?php echo $this->crud_model->getField('career', ['id' => $detail->career_id], 'Title'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch :</label><?php echo $this->crud_model->getField('branches', ['id' => $detail->branch_id], 'PageTitle'); ?>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Applicant ID :</label><?php echo $detail->application_id; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name :</label><?php  echo implode(' ',[$detail->first_name, $detail->middle_name, $detail->last_name]); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DOB :</label><?php echo $detail->bod; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Age :</label><?php echo $detail->age; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender :</label> <?php echo $detail->gender; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Marital Status : </label><?php echo $detail->marital_status; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile :</label><?php echo $detail->phone_number; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email :</label><?php echo $detail->email; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nationality :</label><?php echo $detail->nationality; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Religion :</label><?php echo $detail->religion; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Driving License :</label><?php echo $detail->driving_license; ?>
                                </div>
                            </div>
                        </div>
                        <h3>Address & Residence Information</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Permanent Provience :</label><?php echo $this->crud_model->getField('provinces', ['id' => $detail->permanent_provience], 'title'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Permanent District :</label><?php echo $this->crud_model->getField('districts', ['id' => $detail->permanent_district], 'title'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Permanent Municipality :</label><?php echo $this->crud_model->getField('municipality', ['id' => $detail->permanent_municipality], 'title'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Permanent Address :</label><?php echo $detail->permanent_ward; ?>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php 
                                    $Temporary_Provience_Name = ($detail->temporary_provience == 0 || $detail->temporary_provience == null) ? $this->crud_model->getField('provinces', ['id' => $detail->permanent_provience], 'title') : $this->crud_model->getField('provinces', ['id' => $detail->temporary_provience], 'title');
                                    $Temporary_District_Name = ($detail->temporary_district == 0 || $detail->temporary_district == null) ? $this->crud_model->getField('districts', ['id' => $detail->permanent_district], 'title'): $this->crud_model->getField('districts', ['id' => $detail->temporary_district], 'title');
                                    $Temporary_Municipality_Name = ($detail->temporary_municipality == 0  || $detail->temporary_municipality == null) ?$this->crud_model->getField('municipality', ['id' => $detail->permanent_municipality], 'title') : $this->crud_model->getField('municipality', ['id' => $detail->temporary_municipality], 'title');
                                    $Temporary_Address = ($detail->temporary_ward == ''  || $detail->temporary_ward == null) ? $detail->permanent_ward: $detail->temporary_ward;
                                    
?>
                                    <label>Temporary Provience :</label><?php echo $Temporary_Provience_Name; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Temporary District :</label><?php echo $Temporary_District_Name; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Temporary Municipality :</label><?php echo $Temporary_Municipality_Name; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Temporary Address :</label><?php echo $Temporary_Address; ?>
                                </div>
                            </div>
                        </div>
                        <h3>Education Information</h3>
                        <div class="table-responsive">  
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th>#</th>   
                                    <th>School/College Name</th>
                                    <th>Board/University</th>
                                    <th>Degree</th>
                                    <th>Faculty</th>
                                    <th>Passed Year</th>
                                    <th>Percentile/GPA</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    if(!empty($education)){ 
                                        foreach($education as $key => $value){  
                                            
                                ?>
                                <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $value['organization'] ?></td>
                                    <td><?php echo $value['board'] ?></td>
                                    <td><?php echo $value['degree'] ?></td>
                                    <td><?php echo $value['faculty'] ?></td>
                                    <td><?php echo $value['passed_year'] ?></td>
                                    <td><?php echo $value['gpa'] ?></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">No Records Found</td>
                                    </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                        </div> 
                        <h3>Work Experience Information</h3>
                        <div class="table-responsive">  
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th>#</th>   
                                    <th>Name of Organization</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Working Period From</th>   
                                    <th>Working Period To</th>   
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    if(!empty($experience)){ 
                                        foreach($experience as $key => $value){  
                                            
                                ?>
                                <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $value['organization'] ?></td>
                                    <td><?php echo $value['position'] ?></td>
                                    <td><?php echo $value['department'] ?></td>
                                    <td><?php echo $value['date_from'] ?></td>
                                    <td><?php echo $value['date_to'] ?></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">No Records Found</td>
                                    </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                        </div>
                        <h3>Training Attended </h3>
                        <div class="table-responsive">  
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th>#</th>   
                                    <th>Training Date</th>
                                    <th>Topic</th>
                                    <th>Name of Training Institution</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    if(!empty($training)){ 
                                        foreach($training as $key => $value){  
                                            
                                ?>
                                <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $value['traning_date'] ?></td>
                                    <td><?php echo $value['title'] ?></td>
                                    <td><?php echo $value['organization'] ?></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">No Records Found</td>
                                    </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                        </div>
                        <h3>References</h3>
                        <div class="table-responsive">  
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th>#</th> 
                                    <th>Organization</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Address</th>   
                                    <th>Mobile Number</th>   
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    if(!empty($references)){ 
                                        foreach($references as $key => $value){  
                                            
                                ?>
                                <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $value['organization'] ?></td>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['position'] ?></td>
                                    <td><?php echo $value['address'] ?></td>
                                    <td><?php echo $value['contact'] ?></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">No Records Found</td>
                                    </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                        </div>
                        <h3>Related Documents</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Handwritten Application :</label><?php echo isset($detail->application) ? "<a href='" . base_url() . $detail->application . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->application) ? "<a href='".base_url() . $detail->application . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CV :</label><?php echo isset($detail->cv) ? "<a href='" . base_url() . $detail->cv . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->cv) ? "<a href='".base_url() . $detail->cv . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Photo :</label><?php echo isset($detail->DocPath) ? "<a href='" . base_url() . $detail->DocPath . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->DocPath) ? "<a href='".base_url() . $detail->DocPath . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Academic Certificates :</label><?php echo isset($detail->certificate) ? "<a href='" . base_url() . $detail->certificate . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->certificate) ? "<a href='".base_url() . $detail->certificate . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Citizenship(Front & Back) :</label><?php echo isset($detail->citizenship) ? "<a href='" . base_url() . $detail->citizenship . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->citizenship) ? "<a href='".base_url() . $detail->citizenship . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Training Certificates :</label><?php echo isset($detail->training_certificate) ? "<a href='" . base_url() . $detail->training_certificate . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->training_certificate) ? "<a href='".base_url() . $detail->training_certificate . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Experience Letter  :</label><?php echo isset($detail->experience_letters) ? "<a href='" . base_url() . $detail->experience_letters . "' target='_blank'>View File</a>" : '' ?>
                                    <?php echo isset($detail->experience_letters) ? "<a href='".base_url() . $detail->experience_letters . "' download>
                                        <button type='button'>Download <i class='fa fa-download' aria-hidden='true'></i> </button>
                                    </a>" : '' ?>
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