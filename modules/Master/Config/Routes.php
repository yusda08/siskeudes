<?php

/** @var TYPE_NAME $routes */
$routes->group('master', ['namespace' => '\Modules\Master\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('perencanaan', function ($routes) {
        $routes->get('/', 'Perencanaan::index');
        $routes->get('rab', 'Perencanaan::rab');
        $routes->get('load_ta_bidang', 'Perencanaan::loadTaBidang');
        $routes->get('load_ta_subbidang', 'Perencanaan::loadTaSubbidang');
        $routes->post('update_jenis_belanja', 'Perencanaan::updateJenisBelanja');
        $routes->get('load-anggaran', 'Rab::loadTaSubbidang');
    });

    $routes->get('load-anggaran', 'Rab::loadAnggaran');
    $routes->get('load-realisasi', 'Kuitansi::loadRealisasi');
});