<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage <?= $title; ?></h3>
                <a href="<?= base_url($redirect . '/form'); ?>" class="btn btn-primary btn-sm pull-right">Add New</a>
            </div>

            <div class="box-body">
                <form action="<?= base_url($redirect . '/all'); ?>" method="GET" class="form-inline mb-3">
                    <div class="form-group">
                        <input type="text" name="table_search" class="form-control" placeholder="Search title..." value="<?= $this->input->get('table_search'); ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>

                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th style="width: 60px;">S.N.</th>
                            <th>Image</th>
                            <th>Title (English)</th>
                            <th>Title (Japanese)</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php 
                            $i = (isset($offset) ? $offset : 0) + 1; 
                            foreach ($items as $item): 
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td>
                                        <?php if (!empty($item->docpath)): ?>
                                            <img src="<?= base_url($item->docpath); ?>" width="50" height="50" class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted small">No Image</span>
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
                                        <a href="<?= base_url($redirect . '/form/' . $item->id); ?>" class="btn btn-xs btn-info">Edit</a>
                                        <a href="<?= base_url($redirect . '/soft_delete/' . $item->id); ?>" 
                                           class="btn btn-xs btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="box-footer clearfix">
                <div class="pull-right">
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>