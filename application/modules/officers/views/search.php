<section class="content">
    <div class="container-fluid">
        <!--<h2 class="text-center display-4">Search</h2>-->
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="Title" class="form-control" placeholder="Title"
                            value="<?php echo set_value('Title', $this->input->get('Title')); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Officer Type</label>
                        <?php
                            $type = array('' => 'Select Type', 'Grievance' => 'Grievance Officer','Information'=> 'Information Officer','Compliance'=> 'Compliance Officer','company-secretary' => 'Company Secretary','Digital Help Desk'=>'Digital Help Desk');
                            echo form_dropdown('type', $type, $this->input->get('type'), array('class' => 'form-control'));
                        ?>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2" id="type">
                            <option value="1"
                                <?php echo set_select('status', 1, $this->input->get('status') == 1 ? true : false); ?>>
                                Active</option>
                            <option value="0"
                                <?php echo set_select('status', 0, $this->input->get('status') == 0 ? true : false); ?>>
                                Enable</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit"
                            value="search"> </div>
                </div>
            </div>
        </form>
    </div>
</section>