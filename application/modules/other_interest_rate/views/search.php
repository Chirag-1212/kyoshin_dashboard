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

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date from <span class="req"></span></label>
                        <input type="date" name="date_from" class="form-control" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date to <span class="req"></span></label>
                        <input type="date" name="date_to" class="form-control" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="Title" class="form-control" placeholder="Title" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control select2" id="type">
                            <option value="Base"
                                <?php echo  set_select('type', 'Base', (isset($detail->type) && $detail->type == 'Base') ? TRUE : ''); ?>>
                                Base Rate</option>
                            <option value="Spread"
                                <?php echo  set_select('type', 'Spread', (isset($detail->type) && $detail->type == 'Spread') ? TRUE : ''); ?>>
                                Spread Rate</option>
                            <option value="Commissions"
                                <?php echo  set_select('type', 'Commissions', (isset($detail->type) && $detail->type == 'Commissions') ? TRUE : ''); ?>>
                                Fee Charge Commissions</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2" id="type">
                            <option value="1">Active</option>
                            <option value="0">Enable</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="SUB_BTN pull-right"><input class="btn btn-sm btn-primary" type="submit" name="submit"
                            value=" search"> </div>
                </div>
            </div>
        </div>
    </form>
</div>