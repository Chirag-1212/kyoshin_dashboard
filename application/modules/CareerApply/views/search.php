<div class="searchboxx">
    <form action="" method="get">
        <div class="close_btn">
            <div class="search_icons">
                <i title="Click Here" class="zmdi zmdi-search"></i>
            </div>
            <div class="search_icon_hide ">
                <i title="Close" class="zmdi zmdi-close-circle-o"></i>
            </div>
        </div>
        <div class="search_box">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Full Name" value="<?php echo $this->input->get('full_name'); ?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Branch Name</label>
                        <select name="branch_id" class="form-control select2" id="branch_id">
                            <option value="">Select Branch Name</option>
                            <?php foreach($branches as $branch){ ?>
                            <option value="<?php echo $branch['id']; ?>"
                                <?php echo  set_select('branch_id', $branch['id'], ($this->input->get('branch_id') == $branch['id']) ? TRUE : ''); ?>>
                                <?php echo $branch['title']; ?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Career Title</label>
                        <select name="career_id" class="form-control select2" id="career_id">
                            <option value="">Select Career Title</option>
                            <?php foreach($careers as $career){ ?>
                            <option value="<?php echo $career['id']; ?>"
                                <?php echo  set_select('career_id', $career['id'], ($this->input->get('career_id') == $career['id']) ? TRUE : ''); ?>>
                                <?php echo $career['title']; ?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="SUB_BTN "><input class="btn btn-sm btn-primary" type="submit" name="submit"
                            value=" search"> </div>
                </div>
            </div>
        </div>
    </form>
</div>