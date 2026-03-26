<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>

                <form class="all_form" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($detail->id) ? $detail->id : ''; ?>">
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Title (English)</label>
                                    <input type="text" name="title_en" class="form-control" placeholder="Enter English Title" 
                                        value="<?php echo isset($detail->title_en) ? $detail->title_en : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Title (Japanese)</label>
                                    <input type="text" name="title_jp" class="form-control" placeholder="Enter Japanese Title" 
                                        value="<?php echo isset($detail->title_jp) ? $detail->title_jp : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-Level (e.g. N5)</label>
                                    <input type="text" name="sub_level" class="form-control" value="<?php echo isset($detail->sub_level) ? $detail->sub_level : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-Text (EN)</label>
                                    <input type="text" name="sub_text_en" class="form-control" value="<?php echo isset($detail->sub_text_en) ? $detail->sub_text_en : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-Text (JP)</label>
                                    <input type="text" name="sub_text_jp" class="form-control" value="<?php echo isset($detail->sub_text_jp) ? $detail->sub_text_jp : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (English)</label>
                                    <textarea name="desc_en" class="form-control" rows="5" placeholder="Enter course description in English"><?php echo isset($detail->desc_en) ? $detail->desc_en : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (Japanese)</label>
                                    <textarea name="desc_jp" class="form-control" rows="5" placeholder="Enter course description in Japanese"><?php echo isset($detail->desc_jp) ? $detail->desc_jp : ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="box-header with-border" style="padding-left: 0; margin-top: 20px;">
                            <h3 class="box-title">Course Highlights</h3>
                        </div>
                        
                        <div id="dynamic-points-wrapper" style="margin-bottom: 15px;">
                            <?php 
                            $saved_points = (isset($detail->course_learn_points)) ? json_decode($detail->course_learn_points, true) : [];
                            if (empty($saved_points)) $saved_points = [['type' => 'check', 'text' => '']];
                            
                            foreach ($saved_points as $item): ?>
                                <div class="row point-row" style="margin-bottom: 8px;">
                                    <input type="hidden" name="point_type[]" value="check">
                                    <div class="col-md-6 col-sm-8 col-xs-10"> <input type="text" name="point_text[]" class="form-control" placeholder="Bullet point description..." value="<?php echo htmlspecialchars($item['text']); ?>">
                                    </div>
                                    <div class="col-md-1 col-sm-2 col-xs-2"> <button type="button" class="btn btn-danger remove-point-btn"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-more-points" class="btn btn-dark btn-sm" style="margin-bottom: 20px;">
                            <i class="fa fa-plus"></i> Add Highlight
                        </button>

                        <div class="box-header with-border" style="padding-left: 0;">
                            <h3 class="box-title">Media & Status</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Image</label>
                                    <input type="file" name="docpath" class="form-control">
                                    <input type="hidden" name="old_docpath" value="<?php echo isset($detail->docpath) ? $detail->docpath : ''; ?>">
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
                        <button type="submit" class="btn btn-primary">Save Course</button>
                        <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('dynamic-points-wrapper');
    
    document.getElementById('add-more-points').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'row point-row';
        div.style.marginBottom = '8px';
        div.innerHTML = `
            <input type="hidden" name="point_type[]" value="check">
            <div class="col-md-6 col-sm-8 col-xs-10"> <input type="text" name="point_text[]" class="form-control" placeholder="Bullet point description...">
            </div>
            <div class="col-md-1 col-sm-2 col-xs-2"> <button type="button" class="btn btn-danger remove-point-btn"><i class="fa fa-trash"></i></button>
            </div>`;
        wrapper.appendChild(div);
    });

    wrapper.addEventListener('click', (e) => {
        if (e.target.closest('.remove-point-btn')) {
            const rows = wrapper.querySelectorAll('.point-row');
            if (rows.length > 1) e.target.closest('.point-row').remove();
            else wrapper.querySelector('input[type="text"]').value = '';
        }
    });
});
</script>