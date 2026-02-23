<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php echo $title; ?>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ISO</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Buy</th>
                                <th>Sell</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                if ($items) {
                                    foreach ($items as $key => $value) {
                                ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->iso3; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php echo $value->unit; ?></td>
                                <td><?php echo $value->buy; ?></td>
                                <td><?php echo $value->sell; ?></td>
                            </tr>
                            <?php }
                                } else { ?>

                            <tr>
                                <td colspan="5" style="text-align:center;">No Records Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    <?php if ($items) { ?>
                    <div class="box-footer clearfix">
                        <?php echo $pagination; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>