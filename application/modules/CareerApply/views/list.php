<style>
    .export-excel{
        top: 0;
        position: absolute;
    }
    #loading {
        /*bottom: 47px;*/
        display: none;
        position: absolute;
        top: 0;
        left: 50%;
        width: 68px;
        height: 37%;
        z-index: 1;
    }
    
    .dot-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 10px;
    }

    .dot {
        width: 7px;
        height: 7px;
        background-color: #45b50c;
        border-radius: 50%;
        margin: 0 2px;
        animation: jump 1s infinite alternate;
    }

    @keyframes jump {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php echo $title; ?>
                    </h3>
                    <div class="box-export"  style="text-align: center;">
                        <button  class="btn btn-danger"  id="loading"> 
                            <div class="dot-container">
                                <div class="dot"></div>
                                <div class="dot"></div>
                                <div class="dot"></div>
                            </div>
                        </button>
                        <button class="btn btn-sm btn-success export-excel" data-url ="<?php echo base_url('CareerApply/admin/getExport'); ?>"><i class="fa fa-file-excel-o"> Export</i> </button>
                        <input type="hidden" name="full_name" class="form-control" id="full_name" placeholder="" value="<?php echo $this->input->get('full_name'); ?>">
                        <input type="hidden" name="branch_id" class="form-control" id="branch_id" placeholder="" value="<?php echo $this->input->get('branch_id'); ?>">
                        <input type="hidden" name="career_id" class="form-control" id="career_id" placeholder="" value="<?php echo $this->input->get('career_id'); ?>">
                    </div>
                    <div class="box-search">
                        <?php include('search.php'); ?>
                    </div>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Job Name</th>
                                <th>Contact</th>
                                <th>Branch For</th>
                                <th>CV</th>
                                <th>Certificate</th>
                                <th>Apply On</th>
                                <!--<th>Status</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                if ($items) {
                                    $i = 1;
                                  foreach ($items as $key => $value) { 
                                    $offset = $offset + $i;
                                    // if ($value->status == '1') {
                                    //     $status = '<span class="label label-success">Active</span>';
                                    // } else {
                                    //     $status = '<span class="label label-danger">Inactive</span>';
                                    // }
                                    

                                ?>
                            <tr>
                                <td><?php echo $offset; ?></td>
                                <td><?php echo implode(' ',[$value->first_name, $value->middle_name, $value->last_name]); ?></td>
                                <td><?php echo $value->email; ?></td>
                                <td><?php echo $this->crud_model->getField('career', ['id' => $value->career_id], 'Title'); ?></td>
                                <td><?php echo $value->phone_number; ?></td>
                                <td><?php echo $this->crud_model->getField('branches', ['id' => $value->branch_id], 'PageTitle'); ?></td>
                                <td>
                                    <?php if($value->cv){ ?>
                                        <a href="<?php echo base_url().$value->cv; ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($value->certificate){ ?>
                                        <a href="<?php echo base_url().$value->certificate; ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                                <td><?php echo ($value->created != '0000-00-00')?$value->created:'-'; ?></td>
                                <!--<td><?php //echo $status; ?></td>-->
                                <td>
                                    <a href="<?php echo base_url('CareerApply/admin/view/' . $value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-eye"></i></a>
                                        <?php 
                                        $check_form = $this->crud_model->get_module_function_for_role('CareerApply', 'edit');
                              if ($check_form == true) {
                            ?>
                                    <a href="<?php echo base_url($redirect.'edit/'.$value->id); ?>"
                                        class="btn bg-purple btn-flat margin"><i class="fa fa-edit"></i></a></a>
                                    <?php } ?>
                                        <?php
                              $check_delete = $this->crud_model->get_module_function_for_role('CareerApply', 'soft_delete');
                              if ($check_delete == true) {
                            ?>
                                    <a data-toggle="modal" data-target="#exampleModal<?php echo $value->id; ?>"
                                        class="btn bg-red btn-flat margin"><i class="fa fa-trash-o"></i></a>

                                    <div class="modal fade" id="exampleModal<?php echo $value->id; ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are You Sure To Delete?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No</button>
                                                    <a href="<?php echo base_url($delete_link . $value->id); ?>"
                                                        class="btn btn-primary">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                   
                                </td>
                            </tr>
                            <?php }
                            } else { ?>

                            <tr>
                                <td colspan="9" style="text-align:center;">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    <?php if ($items) { ?>
                    <div class="box-footer clearfix">
                        <?php echo $pagination; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>