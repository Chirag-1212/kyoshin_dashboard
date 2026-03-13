<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?> list</h3>
                <div class="box-tools pull-right">
                    <a href="<?= base_url($form_link); ?>" class="btn btn-primary btn-sm">add new image</a>
                </div>
            </div>
            
            <div class="box-body">
                <form method="get" action="<?= base_url($redirect . '/all'); ?>" class="form-inline mb-3">
                    <div class="form-group">
                        <input type="text" name="table_search" class="form-control" placeholder="search by news_id" value="<?= $this->input->get('table_search'); ?>">
                    </div>
                    <button type="submit" class="btn btn-default">search</button>
                    <a href="<?= base_url($redirect . '/all'); ?>" class="btn btn-default">clear</a>
                </form>

                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>news_id</th>
                            <th>image (docpath)</th>
                            <th>status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $row): ?>
                                <tr>
                                    <td><?= $row->id; ?></td>
                                    <td><?= $row->news_id; ?></td>
                                    <td>
                                        <?php if (!empty($row->docpath)): ?>
                                            <img src="<?= base_url($row->docpath); ?>" alt="gallery image" style="width: 80px; height: auto;">
                                        <?php else: ?>
                                            no image
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= ($row->status == 1) ? '<span class="label label-success">active</span>' : '<span class="label label-danger">deleted</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url($form_link . $row->id); ?>" class="btn btn-warning btn-sm">edit</a>
                                        <a href="<?= base_url($delete_link . $row->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('are you sure you want to remove this image?');">delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">no gallery images found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="box-footer">
                <?= $pagination; ?>
            </div>
        </div>
    </div>
</div>