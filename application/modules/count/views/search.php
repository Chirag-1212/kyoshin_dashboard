<section class="content">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-search"></i> Filter Counts</h3>
        </div>
        <form action="<?php echo base_url($redirect . '/admin/all'); ?>" method="get">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Date From</label>
                            <input type="date" name="date_from" class="form-control" value="<?php echo $this->input->get('date_from'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Date To</label>
                            <input type="date" name="date_to" class="form-control" value="<?php echo $this->input->get('date_to'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="search title..." value="<?php echo $this->input->get('title'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="1" <?php echo ($this->input->get('status') === '1') ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo ($this->input->get('status') === '0') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="<?php echo base_url($redirect . '/admin/all'); ?>" class="btn btn-default">Reset</a>
            </div>
        </form>
    </div>
</section>