<section class="content">
      <div class="container-fluid"> 
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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Question <span>*</span></label>
                      <input type="text" name="question" class="form-control" id="question" placeholder="Question" value="<?php echo (((isset($detail->question)) && $detail->question != '')? $detail->question : '') ?>">
                    </div> 
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Question Nepali</label>
                      <input type="text" name="question_nepali" class="form-control" id="question_nepali" placeholder="Question Nepali" value="<?php echo (((isset($detail->question_nepali)) && $detail->question_nepali != '')? $detail->question_nepali : '') ?>">
                    </div> 
                  </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select name="faq_cat" class="form-control select2" id="faq_cat">
                              <option value>Select Category</option>
                              <?php foreach ($faq_category as $key => $value) { ?>
                                <option value="<?php echo $value->id ?>" <?php echo (((isset($detail->faq_cat)) && $detail->faq_cat == $value->id) ? 'selected' : '') ?>><?php echo $value->title; ?></option>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>    
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Answer</label> 
                      <textarea name="answer" id="description" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->answer)) && $detail->answer != '')? $detail->answer : '') ?></textarea>
                    </div> 
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Answer Nepali</label> 
                      <textarea name="answer_nepali" id="DescriptionNepali" class="form-control" rows="5" cols="80" autocomplete="off"><?php echo (((isset($detail->answer_nepali)) && $detail->answer_nepali != '')? $detail->answer_nepali : '') ?></textarea>
                    </div> 
                  </div> 
                </div>
                <div class="row">  
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control select2" id="status">
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
<script>
  function responsive_filemanager_callback(field_id){  
        var url=$('#'+field_id).val();
        // alert('yo'); 
        $('#'+field_id).next().next().attr('src',url);
        $('#'+field_id).next().next().show(); 
  } 
</script>