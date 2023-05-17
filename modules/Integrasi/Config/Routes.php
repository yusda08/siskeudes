<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Routes
 *
 * @author Yusda Helmani
 */
$routes->group('integrasi', ['namespace' => '\Modules\Integrasi\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('referensi', function ($routes) {
        $routes->get('/', 'Referensi::index');
        $routes->post('input_rekening', 'Referensi::inputDataRekening');
        $routes->post('input_lokasi', 'Referensi::inputDataLokasi');
    });

    $routes->group('rab', function ($routes) {
        $routes->get('/', 'Rab::index');
        $routes->post('input_rab', 'Rab::inputDataRab');
        $routes->post('input_perencanaan', 'Rab::inputDataPerencanaan');
    });

    $routes->group('spp_spj', function ($routes) {
        $routes->get('/', 'Spp_spj::index');
        $routes->post('input_spp', 'Spp_spj::inputDataSpp');
        $routes->post('input_spj', 'Spp_spj::inputDataSpj');
    });

    $routes->group('data', function ($routes) {
        $routes->get('rekening', 'Data_Api::getRekening');
    });
});
