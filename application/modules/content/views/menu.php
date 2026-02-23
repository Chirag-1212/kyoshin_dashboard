<section class="content">
    <div class="container-fluid">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <?php echo $title ?>
                </h3>
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalAdd"
                    style="margin-left: 10px;"><i class=" fa fa-plus-circle" aria-hidden="true"></i></button>
                <a href="<?php echo base_url('content/admin/all/em'); ?>" type="button" class="btn btn-sm btn-primary"
                    style="margin-left: 10px;"><i class=" fa fa-list " aria-hidden="true"></i></a>

                <!-- Modal -->
                <div class="modal fade" id="myModalAdd" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <h4 class="modal-title">Modal Header</h4> -->
                            </div>
                            <div class="modal-body">
                                <form class="all_form" method="post" action enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title <span>*</span></label>
                                                <input type="text" name="PageTitle" class="form-control" id="PageTitle"
                                                    placeholder="PageTitle"
                                                    value="<?php echo (((isset($detail->PageTitle)) && $detail->PageTitle != '') ? $detail->PageTitle : '') ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title Nepali</label>
                                                <input type="text" name="PageTitleNepali" class="form-control"
                                                    id="PageTitleNepali" placeholder="PageTitleNepali"
                                                    value="<?php echo (((isset($detail->PageTitleNepali)) && $detail->PageTitleNepali != '') ? $detail->PageTitleNepali : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Parent</label>
                                                <select name="parent_id" class="form-control" id="parent_id" required>
                                                    <?php echo $html; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Url <span>*</span></label>
                                                <input type="text" name="link" class="form-control" id="link"
                                                    placeholder="link"
                                                    value="<?php echo (((isset($detail->link)) && $detail->link != '') ? $detail->link : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Show On</label>
                                                <select name="show_type" class="form-control" id="show_type">
                                                    <option value="TOP"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'TOP') ? 'selected' : '') ?>>
                                                        TOP</option>
                                                    <option value="MAIN"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'MAIN') ? 'selected' : '') ?>>
                                                        MAIN</option>
                                                    <option value="BOTTOM"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTTOM') ? 'selected' : '') ?>>
                                                        BOTTOM</option>
                                                    <option value="BOTH"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTH') ? 'selected' : '') ?>>
                                                        BOTH</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order</label>
                                                <input type="number" name="rank" class="form-control" id="rank"
                                                    placeholder="Order Number"
                                                    value="<?php echo (((isset($detail->rank)) && $detail->rank != '') ? $detail->rank : 0) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" name="submit"
                                                    class="form-control btn btn-sm btn-primary" id="submit"
                                                    value="Save">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Edit model -->
                <!-- Modal -->
                <div class="modal fade" id="myModalEdit" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <h4 class="modal-title">Modal Header</h4> -->
                            </div>
                            <div class="modal-body">
                                <form class="all_form" method="post"
                                    action="<?php echo base_url('content/admin/menu_edit'); ?>"
                                    enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title <span>*</span></label>
                                                <input type="text" name="PageTitle" class="form-control" id="PageTitle"
                                                    placeholder="PageTitle"
                                                    value="<?php echo (((isset($detail->PageTitle)) && $detail->PageTitle != '') ? $detail->PageTitle : '') ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title Nepali</label>
                                                <input type="text" name="PageTitleNepali" class="form-control"
                                                    id="PageTitleNepali" placeholder="PageTitleNepali"
                                                    value="<?php echo (((isset($detail->PageTitleNepali)) && $detail->PageTitleNepali != '') ? $detail->PageTitleNepali : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="url_only" style="display:none;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Url <span>*</span></label>
                                                <input type="text" name="link" class="form-control" id="link"
                                                    placeholder="link"
                                                    value="<?php echo (((isset($detail->link)) && $detail->link != '') ? $detail->link : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Show On</label>
                                                <select name="show_type" class="form-control" id="show_type">
                                                    <option value="TOP"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'TOP') ? 'selected' : '') ?>>
                                                        TOP</option>
                                                    <option value="MAIN"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'MAIN') ? 'selected' : '') ?>>
                                                        MAIN</option>
                                                    <option value="BOTTOM"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTTOM') ? 'selected' : '') ?>>
                                                        BOTTOM</option>
                                                    <option value="BOTH"
                                                        <?php echo (((isset($detail->show_type)) && $detail->show_type == 'BOTH') ? 'selected' : '') ?>>
                                                        BOTH</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label>Order</label>-->
                                        <!--        <input type="number" name="rank" class="form-control" id="rank"-->
                                        <!--            placeholder="Order Number"-->
                                        <!--            value="<?php echo (((isset($detail->rank)) && $detail->rank != '') ? $detail->rank : 0) ?>">-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" name="submit"
                                                    class="form-control btn btn-sm btn-primary" id="submit"
                                                    value="Save">
                                                <input type="hidden" name="id"
                                                    class="form-control btn btn-sm btn-primary" id="record_id" value="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-remove"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="menu_sorting">
                            <ol class="sortable">
                                <?php echo $menu; ?>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="save_menu_order">
                            <button type="button" id="serialize_menu" class="btn btn-sm btn-primary"
                                style="float: right;">Save New Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>