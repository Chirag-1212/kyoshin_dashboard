<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About Us Settings</h3>
                </div>
                
                <form class="all_form" method="post" action="<?php echo base_url('about/admin/form'); ?>" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title (English)</label>
                                    <input type="text" name="title_en" class="form-control" id="title_en"
                                        placeholder="Enter English Title"
                                        value="<?php echo (((isset($detail->title_en)) && $detail->title_en != '') ? $detail->title_en : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title (Japanese)</label>
                                    <input type="text" name="title_jp" class="form-control" id="title_jp"
                                        placeholder="Enter Japanese Title"
                                        value="<?php echo (((isset($detail->title_jp)) && $detail->title_jp != '') ? $detail->title_jp : '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (English)</label>
                                    <textarea name="desc_en" id="content_en" class="form-control" rows="10" 
                                        placeholder="Write English description here..."><?php echo (((isset($detail->desc_en)) && $detail->desc_en != '') ? $detail->desc_en : '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (Japanese)</label>
                                    <textarea name="desc_jp" id="content_jp" class="form-control" rows="10" 
                                        placeholder="Write Japanese description here..."><?php echo (((isset($detail->desc_jp)) && $detail->desc_jp != '') ? $detail->desc_jp : '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="box-header with-border" style="padding-left: 0;">
                            <h3 class="box-title">Media & Status</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" name="docpath" class="form-control" id="docpath">
                                    
                                    <?php if ((isset($detail->docpath)) && $detail->docpath != '') { ?>
                                        <div style="margin-top: 10px;">
                                            <img src="<?php echo base_url().$detail->docpath; ?>" class="img_cl" 
                                                 style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                                            <input type="hidden" name="old_docpath" value="<?php echo $detail->docpath; ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" <?php echo (isset($detail->status) && $detail->status == '1') ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo (isset($detail->status) && $detail->status == '0') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php echo (((isset($detail->id)) && $detail->id != '') ? $detail->id : '') ?>">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>