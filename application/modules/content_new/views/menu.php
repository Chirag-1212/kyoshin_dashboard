<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <?php echo $title ?>
        </h3>
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalAdd" style="margin-left: 10px;"><i class=" fa fa-plus-circle" aria-hidden="true"></i></button>
        <a href="<?php echo base_url('content/admin/all'); ?>" type="button" class="btn btn-sm btn-primary" style="margin-left: 10px;"><i class=" fa fa-list " aria-hidden="true"></i></a>

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
                        <input type="text" name="title" class="form-control" id="title" placeholder="title" value="<?php echo (((isset($detail->title)) && $detail->title != '') ? $detail->title : '') ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order_no" class="form-control" id="order_no" placeholder="Order Number" value="<?php echo (((isset($detail->order_no)) && $detail->order_no != '') ? $detail->order_no : 0) ?>">
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
                        <label>External Url <span>*</span></label>
                        <input type="text" name="external_url" class="form-control" id="external_url" placeholder="external_url" value="<?php echo (((isset($detail->external_url)) && $detail->external_url != '') ? $detail->external_url : '') ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Save">
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
                <form class="all_form" method="post" action="<?php echo base_url('content/admin/menu_edit'); ?>" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Title <span>*</span></label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="title" value="<?php echo (((isset($detail->title)) && $detail->title != '') ? $detail->title : '') ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="url_only" style=" display:none;">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>External Url <span>*</span></label>
                        <input type="text" name="external_url" class="form-control" id="external_url" placeholder="external_url" value="<?php echo (((isset($detail->external_url)) && $detail->external_url != '') ? $detail->external_url : '') ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="submit" name="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Save">
                        <input type="hidden" name="id" class="form-control btn btn-sm btn-primary" id="record_id" value="">
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
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
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
              <button type="button" id="serialize_menu" class="btn btn-sm btn-primary" style="float: right;">Save New Order</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>