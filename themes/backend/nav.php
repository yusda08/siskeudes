<?php
$a = aksesLog();
$request = \Config\Services::request();
$folder = $request->uri->getSegment(1);
$controller = $request->uri->getSegment(2);
?>
<a href="#" class="brand-link navbar-dark text-center">
    <!--    <img src='<?= logoKab(); ?>' alt="" class="brand-image img-circle elevation-3"
         style="opacity: .8">-->
    <span style="font-size: 14pt; font-weight: bold; color: #FFFFFF"
          class="brand-text font-weight-light ">SISKEUDES</span>
</a>
<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= logoKab(); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?= $a['username']; ?></a>
        </div>
    </div>
    <nav class="mt-2">
        <ul id='navig' class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
            data-accordion="false">
            <?php
            foreach ($menu as $row) {
                if ($row['parent'] == 0) {
                    if ($row['link'] != '#') {
                        ?>
                        <li class="nav-item">
                            <a href="<?= site_url($row['link']); ?>" class="nav-link">
                                <i class="nav-icon fas <?= $row['icon']; ?>"></i>
                                <p><?= $row['nama']; ?></p>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas <?= $row['icon']; ?>"></i>
                                <p>
                                    <?= $row['nama']; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                foreach ($menu as $row_p) {
                                    if ($row_p['parent'] == $row['id']) {
                                        ?>
                                        <li class="nav-item menu-open">
                                            <a href="<?= site_url($row_p['link']); ?>" class="nav-link">
                                                <i class="far <?= $row_p['icon']; ?> nav-icon"></i>
                                                <p><?= $row_p['nama']; ?></p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    <?php
    //if (empty($controller) and empty($method)) {
    //    $url = $folder;
    //} elseif (!empty($method)) {
    //    $url = $folder . '/' . $controller;
    //} else {
    //    $url = $folder . '/' . $controller . '/' . $method;
    //}
    //if (empty($controller) and empty($method)) {
    //    $url = $folder;
    //} else {
    //    $url = $folder . '/' . $controller;
    //}
    if ($folder) {
        $url = $folder;
    }
    if ($controller) {
        $url .= '/' . $controller;
    }
    ?>
    $(function () {
        $('#navig a[href~="<?= site_url($url); ?>"]').parents('li').addClass('menu-open').parent('a');
        $('li.menu-open a[href~="#"]').addClass('active');
        $('li.menu-open a[href~="<?= site_url($url); ?>"]').addClass('active');
//        console.log('<?=site_url($url);?>');
    });
</script>