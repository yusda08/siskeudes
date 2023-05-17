<?php

/** @var TYPE_NAME $routes */

$routes->group('report', ['namespace' => '\Modules\Report\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('anggaran-belanja', function ($routes) {
        $routes->get('/', 'AnggaranBelanja::index');
        $routes->get('excel', 'AnggaranBelanja::excel');
    });

    $routes->group('bukti-belanja', function ($routes) {
        $routes->get('/', 'BuktiBelanja::index');
        $routes->get('pdf', 'BuktiBelanja::pdf');
    });

    $routes->group('realisasi-kegiatan', function ($routes) {
        $routes->get('/', 'RealisasiKegiatan::index');
        $routes->get('excel', 'RealisasiKegiatan::excel');
    });

});
