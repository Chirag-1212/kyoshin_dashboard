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
                      <label>Name <span>*</span></label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php echo (((isset($detail->name)) && $detail->name != '')? $detail->name : '') ?>" required>
                    </div> 
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Code<span>*</span></label>
                      <input type="text" name="code" class="form-control" id="code" placeholder="Code" value="<?php echo (((isset($detail->code)) && $detail->code != '')? $detail->code : '') ?>" required>
                    </div> 
                  </div>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Symbol <span>*</span></label>
                      <input type="text" name="symbol" class="form-control" id="symbol" placeholder="Symbol" value="<?php echo (((isset($detail->symbol)) && $detail->symbol != '')? $detail->symbol : '') ?>" required>
                    </div> 
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control selct2" id="status">
                        <option value="1" <?php echo (((isset($detail->status)) && $detail->status == '1') ? 'selected' : '') ?>>Active</option>
                        <option value="0" <?php echo (((isset($detail->status)) && $detail->status == '0') ? 'selected' : '') ?>>Inactive</option> 
                      </select>  
                    </div> 
                  </div>
                </div> 
                <div class="row"> 
                  <div class="col-md-12">
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