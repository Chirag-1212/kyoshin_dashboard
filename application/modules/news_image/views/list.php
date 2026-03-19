<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">manage <?= $title; ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= base_url($redirect . '/form'); ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> add new
                    </a>
                </div>
            </div>

            <div class="box-body">
                <div class="well well-sm">
                    <form action="<?= base_url($redirect . '/all'); ?>" method="GET" class="form-inline">
                        <input type="text" name="table_search" class="form-control" placeholder="search description..." value="<?= $this->input->get('table_search'); ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                        <a href="<?= base_url($redirect . '/all'); ?>" class="btn btn-default">clear</a>
                    </form>
                </div>

                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr class="bg-gray">
                            <th width="5%" class="text-center">s.n.</th>
                            <th width="10%">image</th>
                            <th>description</th>
                            <th width="10%" class="text-center">status</th>
                            <th width="15%" class="text-center">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php $i = $offset + 1; foreach ($items as $item): ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td>
                                        <?php if (!empty($item->docpath)): ?>
                                            <img src="<?= base_url($item->docpath); ?>" width="60" class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted small">no image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($item->description) ? $item->description : '<span class="text-muted">none</span>'; ?></td>
                                    <td class="text-center">
                                        <span class="label <?= ($item->status == 1) ? 'label-success' : 'label-danger'; ?>">
                                            <?= ($item->status == 1) ? 'active' : 'deleted'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url($redirect . '/form/' . $item->id); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                            <a href="<?= base_url($redirect . '/soft_delete/' . $item->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('are you sure?');"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">no records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix"><div class="pull-right"><?= $pagination; ?></div></div>
        </div>
    </div>
</div>