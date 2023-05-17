<!DOCTYPE html>
<html>
<head>
    <?= $this->include('backend/head'); ?>
</head>
<body class="sidebar-mini control-sidebar-slide-open text-sm hold-transition layout-fixed layout-navbar-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark navbar-dark border-bottom-0">
        <?= $this->include('backend/nav_header'); ?>
    </nav>
    <aside class="main-sidebar elevation-4 sidebar-dark-gray">
        <?= $this->include('backend/nav'); ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php if (isset($ribbon)) { ?>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"><?= $ribbon; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li><a href="#"><i class="fa fa-dashboard"></i><?= aksesLog()['username']; ?></a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <?php } ?>

        <!-- Main content -->
        <section class="content">
            <div id='notivs'>
                <?= $this->include('backend/notifikasi'); ?>
            </div>
            <?= $this->include($content); ?>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer bg-gray-active">
        <?= $this->include('backend/footer'); ?>
    </footer>
</div>
</body>
</html>