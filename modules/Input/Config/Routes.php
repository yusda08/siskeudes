<?php

/** @var TYPE_NAME $routes */

$routes->group('belanja', ['namespace' => '\Modules\Input\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'Belanja::index');
    $routes->get('kuitansi', 'Belanja::kuitansi');
    $routes->get('add-kuitansi', 'Belanja::addBukti');
    $routes->post('store-bukti', 'Belanja::storeBukti');
    $routes->post('delete-kuitansi', 'Belanja::deleteBukti');
    $routes->post('posting-kuitansi', 'Belanja::postingBukti');
});

$routes->group('validasi-belanja', ['namespace' => '\Modules\Input\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'ValidasiBelanja::index');
    $routes->get('form-validasi', 'ValidasiBelanja::formValidasi');
    $routes->post('validasi', 'ValidasiBelanja::validationBukti');
    $routes->post('posting', 'ValidasiBelanja::postingValidation');
    $routes->post('koreksi', 'ValidasiBelanja::koreksi');
});