<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
              <div>
                  <?php include('search.php'); ?>
              </div>
            <h3 class="card-title">
              <?php
              $check_form = $this->crud_model->get_module_function_for_role($redirect, $form_check_value);
              if ($check_form == true) {
              ?>
                <a href="<?php echo base_url($form_link); ?>" class="btn btn-sm btn-primary">Add New</a>
              <?php } ?>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>BoID</th>
                  <th>SH Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                if ($items) {
                  foreach ($items as $key => $value) {
                    if ($value->status == '1') {
                      $status = 'Live';
                    } else {
                      $status = 'Not Live';
                    }
                ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo $value->boid; ?></td>
                      <td><?php echo $value->sh_name; ?></td>
                      <td><?php echo $status; ?></td>
                      <td>
                        <?php
                        $check_soft_delete = $this->crud_model->get_module_function_for_role($redirect, $delete_check_value);
                        if ($check_soft_delete == true) {
                        ?>
                          <a href="<?php echo base_url($delete_link . $value->id); ?>" class="btn btn-sm btn-danger" style="margin: 5px;">Delete</a>
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
            <!-- /.card-body -->
            <?php if ($items) { ?>
              <div class="card-footer clearfix">
                <?php echo $pagination; ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>