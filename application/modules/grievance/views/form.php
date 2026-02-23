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
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Name : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->name)) && $detail->name != '')? $detail->name : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Email : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->email)) && $detail->email != '')? $detail->email : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Mobile no. : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->mobno)) && $detail->mobno != '')? $detail->mobno : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Subject : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->subject)) && $detail->subject != '')? $detail->subject : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Attachment : </p>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <p><?php echo (isset($detail->DocPath) && $detail->DocPath != '') ? "<a href='" . base_url() . '/uploads/grievance/' . $detail->DocPath . "' class='btn btn-sm btn-info' style='float: right;' target='_blank'>View File</a>" : ''
                ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Issue : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->issue)) && $detail->issue != '')? $detail->issue : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-groups">
                                    <p>Date : </p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-groups">
                                    <p><?php echo (((isset($detail->date)) && $detail->date != '')? $detail->date : '') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-groups">
                                    <p>Issue Reply : </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-groups">
                                    <textarea name="issue_reply" id="description" class="form-control" rows="5"
                                        cols="80"
                                        autocomplete="off"><?php echo (((isset($detail->issue_reply)) && $detail->issue_reply != '')? $detail->issue_reply : '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-groups">
                                    <input type="submit" name="submit" class="form-control btn btn-sm btn-primary"
                                        id="submit" value="Submit">
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