<section class="content">
  <div class="container-fluid">
    <form class="all_form" method="post" action enctype="multipart/form-data">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"><?php echo $title ?></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="margin-right: 10px;">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="margin-right: 10px;">Confirm Password</label>
                <input type="password" name="password_conf" class="form-control" id="password_conf" placeholder="Confirm Password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="SUB_BTN">
                <input type="submit" name="submit" class=" btn btn-sm btn-primary" id="submit" value="Save"> 
                <input type="hidden" name="id" class="form-control btn btn-sm btn-primary" id="submit" value="<?php echo (((isset($detail->id)) && $detail->id != '') ? $detail->id : '') ?>">
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