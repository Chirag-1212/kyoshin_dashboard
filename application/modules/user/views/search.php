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
                            <label>Title</label>
                            <input type="text" name="Title" class="form-control" placeholder="Title"
                                value="<?php echo set_value('Title', $this->input->get('Title')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control select2" id="type">
                                <option value="">|Select Status </option>
                                <option value="1"
                                    <?php echo set_select('status', 1, $this->input->get('status') == 1? true: false); ?>>
                                    Active
                                </option>
                                <option value="0"
                                    <?php echo set_select('status', 0,  $this->input->get('status') == 0? true: false); ?>>
                                    Enable
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit"
                                value="Search"> </div>
                    </div>
                </div>
            </div>
        </form>
    </div>