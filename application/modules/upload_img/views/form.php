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
                    <?php echo validation_errors('<div class="error_message" style="color:red">', '</div>'); ?>
                    
                    <div class="box-body">
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Multiple Files</label>
                                    <input type="file" class="form-control" name="files[]" multiple/>
                                </div>
                            </div>
                            <!--<div class="col-md-6">-->
                            <!--   <div class="form-group">-->
                            <!--       <label>Image</label>-->
                            <!--       <input type="file" name="CoverImage" class="form-control" id="CoverImage"-->
                            <!--           placeholder="CoverImage"-->
                            <!--           value="<?php echo (((isset($detail->CoverImage)) && $detail->CoverImage != '')? $detail->CoverImage : '') ?>"-->
                            <!--           readonly="readonly">-->
                            <!--       <?php if((isset($detail->CoverImage)) && $detail->CoverImage != ''){ ?>-->
                            <!--            <img src="<?php echo base_url().$detail->CoverImage; ?>" class="img_cl img-fluid" id="defff0" style="max-height: 675px;object-fit: contain;">-->
                            <!--       <?php }else{ ?>-->
                            <!--       <img src="" class="img_cl img-fluid" id="defff0"-->
                            <!--           style="display:none;max-height: 675px;object-fit: contain;">-->
                            <!--       <?php }?>-->
                            <!--   </div>-->
                            <!--</div>-->
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary"
                                        id="submit" value="Save">
                                    <input type="hidden" name="id" class="form-control btn btn-sm btn-primary"
                                        id="submit"
                                        value="<?php echo (((isset($detail->id)) && $detail->id != '')? $detail->id : '') ?>">
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