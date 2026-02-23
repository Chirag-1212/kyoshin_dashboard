<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php echo $title; ?>
                    </h3>

                    <?php include('search.php'); ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mob no.</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        if(!empty($items)){ 
                            foreach($items as $key => $value){  
                                
                                if($value->status == '1'){
                                    $status = "Approved";
                                }else{
                                    $status = "Pending";
                                }
                    ?>
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td><?php echo $value->name ?></td>
                                <td><?php echo $value->email ?></td>
                                <td><?php echo $value->mobno ?></td>
                                <td><?php echo $value->subject ?></td>
                                <td><?php echo $value->date ?></td>
                                <td><?php echo $status ?></td>
                                <td>
                                    <?php 
                              $check_form = $this->crud_model->get_module_function_for_role('grievance', 'form');
                              if ($check_form == true) {
                            ?>
                                    <a href="<?php echo base_url($redirect.'form/'.$value->id); ?>"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <?php } ?>

                                    <?php 
                              $check_view = $this->crud_model->get_module_function_for_role('grievance', 'view');
                              if ($check_view == true) {
                            ?>
                                    <a href="<?php echo base_url($redirect.'view/'.$value->id); ?>"
                                        class="btn bg-green btn-flat margin"><i class="fa fa-eye"></i></a>
                                    <?php } ?>

                                    <?php
                              $check_delete = $this->crud_model->get_module_function_for_role('grievance', 'soft_delete');
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
                                                    <a href="<?php echo base_url($redirect.'soft_delete/'.$value->id); ?>"
                                                        class="btn btn-primary">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php }else{ ?>
                            <tr>
                                <td colspan="10" style="text-align:center;">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    <?php if($items){ ?>
                    <div class="box-footer clearfix">
                        <?php echo $pagination; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>