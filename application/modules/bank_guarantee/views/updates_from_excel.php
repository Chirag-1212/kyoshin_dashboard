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
            <div class="col-md-4">
              <div class="form-group">
                <label>File</label>
                <input type="file" name="FileName" class="form-control" id="FileName" placeholder="File" value="">
                <?php echo form_error('FileName', '<div class="error_message">', '</div>'); ?> 
              </div>
            </div>
          </div> 
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Save"> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>