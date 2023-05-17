<?php

/** @var TYPE_NAME $routes */
$routes->group('mapping', ['namespace' => '\Modules\Mapping\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('belanja', function ($routes) {
        $routes->get('/', 'Map_belanja::index');
        $routes->post('input_data', 'Map_belanja::store');
        $routes->post('delete_data', 'Map_belanja::delete');
    });

    $routes->group('pegawai', function ($routes) {
        $routes->get('/', 'Map_pegawai::index');
        $routes->post('input_data', 'Map_pegawai::store');
    });
});

