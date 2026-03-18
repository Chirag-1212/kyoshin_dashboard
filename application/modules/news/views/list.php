<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage <?= $title; ?></h3>
                <a href="<?= base_url($redirect . '/admin/form'); ?>" class="btn btn-primary btn-sm pull-right">Add New</a>
            </div>

            <div class="box-body">
                <form action="<?= base_url($redirect . '/admin/all'); ?>" method="GET" class="form-inline mb-3">
                    <div class="form-group">
                        <input type="text" name="table_search" class="form-control" placeholder="Search title..." value="<?= $this->input->get('table_search'); ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>

                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Image</th>
                            <th>Title (EN)</th>
                            <th>Title (JP)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $item): ?>
                                <tr>
                                    <td><?= $item->id; ?></td>
                                    <td>
                                        <?php if (!empty($item->docpath)): ?>
                                            <img src="<?= base_url($item->docpath); ?>" width="50" height="50" class="img-thumbnail">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item->title_en; ?></td>
                                    <td><?= $item->title_jp; ?></td>
                                    <td>
                                        <span class="label <?= ($item->status == 1) ? 'label-success' : 'label-danger'; ?>">
                                            <?= ($item->status == 1) ? 'Active' : 'Deleted'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url($redirect . '/admin/form/' . $item->id); ?>" class="btn btn-xs btn-info">Edit</a>
                                        <a href="<?= base_url($redirect . '/admin/soft_delete/' . $item->id); ?>" 
                                           class="btn btn-xs btn-danger" 
                                           onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No records found.</td></tr>
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