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
                    <div class="box-body">
                       <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="FileName" class="form-control" id="FileName" placeholder="File" value="">
                                    <?php echo form_error('FileName', '<div class="error_message">', '</div>'); ?> 
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Save"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>