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
                <label>Title <span>*</span></label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="<?php echo (((isset($detail->title)) && $detail->title != '') ? $detail->title : '') ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Type <span>*</span></label>
                <select name="type" class="form-control selct2" id="type">
                  <option value>Select Type</option>
                  <option value="about" <?php echo (((isset($detail->type)) && $detail->type == 'about') ? 'selected' : '') ?>>About Us</option>
                  <option value="contact" <?php echo (((isset($detail->type)) && $detail->type == 'contact') ? 'selected' : '') ?>>Contact</option>
                  <option value="policy" <?php echo (((isset($detail->type)) && $detail->type == 'policy') ? 'selected' : '') ?>>Privacy/Policy</option>
                  <option value="terms" <?php echo (((isset($detail->type)) && $detail->type == 'terms') ? 'selected' : '') ?>>Terms & Conditions</option>
                  <option value="others" <?php echo (((isset($detail->type)) && $detail->type == 'others') ? 'selected' : '') ?>>Others</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 ext_url" style="<?php echo (((isset($detail->type)) && $detail->type == 'others') ? '' : 'display:none;') ?>">
              <div class="form-group">
                <label>External Url <span>*</span></label>
                <input type="text" name="external_url" class="form-control" id="external_url" placeholder="External Url" value="<?php echo (((isset($detail->external_url)) && $detail->external_url != '') ? $detail->external_url : '') ?>">
              </div>
            
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Parent</label>
                <select name="parent_id" class="form-control selct2" id="parent_id">
                  <?php echo $html; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="sub_title" class="form-control" id="sub_title" placeholder="Subtitle" value="<?php echo (((isset($detail->sub_title)) && $detail->sub_title != '') ? $detail->sub_title : '') ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Featured Image</label>
                <input type="text" name="featured_image" class="form-control" id="featured_image" placeholder="featured_image" value="<?php echo (((isset($detail->featured_image)) && $detail->featured_image != '') ? $detail->featured_image : '') ?>" readonly="readonly">
                <a class="btn btn-default featured_image button_cls" type="button">Upload</a>
                <?php if ((isset($detail->featured_image)) && $detail->featured_image != '') { ?>
                  <img src="<?php echo $detail->featured_image; ?>" class="img_cl" id="defff0">
                <?php } else { ?>
                  <img src="" class="img_cl" id="defff0" style="display:none">
                <?php } ?>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="form-groups">
                <label>Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->description)) && $detail->description != '') ? $detail->description : '') ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Show On Menu</label>
                <select name="show_on_menu" class="form-control selct2" id="show_on_menu">
                  <option value="Yes" <?php echo (((isset($detail->show_on_menu)) && $detail->show_on_menu == 'Yes') ? 'selected' : '') ?>>Yes</option>
                  <option value="No" <?php echo (((isset($detail->show_on_menu)) && $detail->show_on_menu == 'No') ? 'selected' : '') ?>>No</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Show On</label>
                <select name="show_type" class="form-control selct2" id="show_type">
                  <option value="TOP" <?php echo (((isset($detail->show_type)) && $detail->show_type == 'TOP') ? 'selected' : '') ?>>TOP</option>
                  <option value="BOTTOM" <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTTOM') ? 'selected' : '') ?>>BOTTOM</option>
                  <option value="BOTH" <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTH') ? 'selected' : '') ?>>BOTH</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Order No</label>
                <input type="number" name="order_no" class="form-control" id="order_no" placeholder="Order Number" value="<?php echo (((isset($detail->order_no)) && $detail->order_no != '') ? $detail->order_no : '') ?>">
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
            <div class="col-md-12">
              <div class="SUB_BTN">
                <input type="submit" name="submit" class="btn btn-sm btn-primary" id="submit" value="Save">
                <input type="hidden" name="id" class="btn btn-sm btn-primary" id="submit" value="<?php echo (((isset($detail->id)) && $detail->id != '') ? $detail->id : '') ?>">
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