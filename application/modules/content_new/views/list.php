<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <?php
              $check_content_form = $this->crud_model->get_module_function_for_role('content', 'form');
              if ($check_content_form == true) {
              ?>
                <a href="<?php echo base_url('content/admin/form/'); ?>" class="btn btn-sm btn-primary">Add New</a>
              <?php } ?>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>S.N.</th>
                  <th>Title</th>
                  <th>Slug</th>
                  <th>Show On Menu</th>
                  <th>Show On Type</th>
                  <th>Created</th>
                  <th>Created By</th>
                  <th>Updated</th>
                  <th>Updated By</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($items) {
                  foreach ($items as $key => $value) {
                    if ($value->updated_by) {
                      $updated_by = $this->db->get_where('users', array('id' => $value->updated_by))->row();
                      if (isset($updated_by->user_name)) {
                        $updated_by = $updated_by->user_name;
                      } else {
                        $updated_by = '';
                      }
                    } else {
                      $updated_by = '';
                    }

                    if ($value->created_by) {
                      $created_by = $this->db->get_where('users', array('id' => $value->created_by))->row();
                      if (isset($created_by->user_name)) {
                        $created_by = $created_by->user_name;
                      } else {
                        $created_by = '';
                      }
                    } else {
                      $created_by = '';
                    }

                    if ($value->status == '1') {
                      $status = "Active";
                    } else {
                      $status = "Inactive";
                    }

                ?>
                    <tr>
                      <td><?php echo $key + 1 ?></td>
                      <td><?php echo $value->PageTitle ?></td>
                      <td><?php echo $value->slug ?></td>
                      <td><?php echo $value->show_on_menu ?></td>
                      <td><?php echo $value->show_type ?></td>
                      <td><?php echo $value->created ?></td>
                      <td><?php echo $created_by ?></td>
                      <td><?php echo $value->updated_on ?></td>
                      <td><?php echo $updated_by ?></td>
                      <td><?php echo $status ?></td>
                      <td>
                        <?php
                        $check_content_edit = $this->crud_model->get_module_function_for_role('content', 'form');
                        if ($check_content_edit == true) {
                        ?>
                          <a title="Edit" href="<?php echo base_url('content/admin/form/' . $value->id); ?>" class="btn btn-sm btn-primary"><i class="zmdi zmdi-edit"></i></a>
                        <?php } ?>
                        <?php
                        $check_content_soft_delete = $this->crud_model->get_module_function_for_role('content', 'soft_delete');
                        if ($check_content_soft_delete == true) {
                        ?>
                          <a title="Delete" class="delete btn btn-sm btn-danger" url="<?php echo base_url('content/admin/soft_delete/' . $value->id); ?>"><i class="zmdi zmdi-delete"></i></a>

                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>

                <?php } else { ?>
                  <tr>
                    <td colspan="11" style="text-align:center;">No Records Found</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <!-- /.card-body -->
            <?php if ($items) { ?>
              <div class="card-footer clearfix">
                <!-- <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul> -->
                <?php echo $pagination; ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>