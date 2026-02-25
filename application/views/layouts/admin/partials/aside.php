<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        $role_id = (int)$this->session->userdata('role_id');
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        $uri3 = $this->uri->segment(3);
        ?>

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url($staff_featured_image); ?>" class="img-circle" alt="<?= $site_settings->short_name ?>">
            </div>
            <div class="pull-left info">
                <p><?= $staff_name; ?></p>
                <a href="<?= base_url("dashboard"); ?>"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
        <?php
        // Get all active menus
        $menus = $this->db->where('status', "1")->order_by('menu', 'ASC')->get('user_menu')->result();

        foreach ($menus as $menu):
            // Get modules under the menu
            $modules = $this->db->where('menu_id', $menu->id)
                                ->where('status', "1")
                                ->order_by('display_name', 'ASC')
                                ->get('module')
                                ->result();
            if (!$modules) continue;
        ?>

            <li class="header"><?= $menu->menu; ?></li>

            <?php foreach ($modules as $module):

                // Admin sees all functions, others by role
                if ($role_id === 1) {
                    $functions = $this->db->where('module_id', $module->id)
                                          ->where_in('function_name', ['all','form','index'])
                                          ->get('module_function')
                                          ->result();
                } else {
                    $functions = $this->db
                        ->select('mf.*')
                        ->from('module_function_role mfr')
                        ->join('module_function mf', 'mf.id = mfr.module_function_id')
                        ->where('mf.module_id', $module->id)
                        ->where('mfr.role_id', $role_id)
                        ->get()
                        ->result();

                    // Filter only 'all', 'form', 'index'
                    $functions = array_filter($functions, function($f) {
                        $fname = strtolower(trim($f->function_name));
                        return in_array($fname, ['all','form','index']);
                    });
                }

                if (empty($functions)) continue;

                // Check if only 'index' function exists
                $function_names = array_map(function($f) {
                    return strtolower(trim($f->function_name));
                }, $functions);

                $only_index = (count($function_names) === 1 && $function_names[0] === 'index');

                // Sort functions: all first, form second, index last
                usort($functions, function($a, $b){
                    $order = ['all'=>1, 'form'=>2, 'index'=>99];
                    $fa = strtolower(trim($a->function_name));
                    $fb = strtolower(trim($b->function_name));
                    $oa = isset($order[$fa]) ? $order[$fa] : 50;
                    $ob = isset($order[$fb]) ? $order[$fb] : 50;
                    return $oa - $ob;
                });
            ?>

                <?php if ($only_index):
                    // Direct main menu link for modules with only index
                    $url = base_url($module->module_name); ?>
                    <li class="<?= ($uri1 == $module->module_name) ? 'active' : ''; ?>">
                        <a href="<?= $url; ?>">
                            <i class="<?= !empty($module->icon) ? $module->icon : 'fa fa-circle'; ?>"></i>
                            <span><?= $module->display_name; ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Module Dropdown -->
                    <li class="treeview <?= ($uri1 == $module->module_name) ? 'active' : ''; ?>">
                        <a href="#">
                            <i class="<?= !empty($module->icon) ? $module->icon : 'fa fa-circle'; ?>"></i>
                            <span><?= $module->display_name; ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>

                        <ul class="treeview-menu">
                            <?php foreach ($functions as $function):
                                $fname = strtolower(trim($function->function_name));

                                if ($fname === 'index') continue; // skip index in dropdown

                                // Set icons
                                if ($fname === 'all') {
                                    $icon = 'fa fa-cogs';
                                } elseif ($fname === 'form') {
                                    $icon = 'fa fa-edit';
                                } else {
                                    $icon = 'fa fa-circle-o';
                                }

                                $url = base_url($module->module_name . '/admin/' . $fname);
                            ?>
                                <li class="<?= ($uri2 == 'admin' && $uri3 == $fname) ? 'active' : ''; ?>">
                                    <a href="<?= $url; ?>"><i class="<?= $icon ?>"></i> <?= $function->display_name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endforeach; ?>

        </ul>
    </section>
</aside>