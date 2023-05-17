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
//Setting  User
$routes->group('utility', ['namespace' => '\Modules\Utility\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('jenis_belanja', function ($routes) {
        $routes->get('/', 'Jenis_belanja::index');
        $routes->get('load_jenis_belanja', 'Jenis_belanja::loadUtiJenisBelanja');
    });

    $routes->group('bukti_pengadaan', function ($routes) {
        $routes->get('/', 'Bukti_pengadaan::index');
        $routes->post('input_data', 'Bukti_pengadaan::inputData');
        $routes->post('delete_data', 'Bukti_pengadaan::deleteData');
        $routes->get('load_bukti_pengadaan', 'Bukti_pengadaan::loadBuktiPengadaan');
        $routes->get('input_client', 'Bukti_pengadaan::inputClient');
    });

    $routes->group('bukti_belanja', function ($routes) {
        $routes->get('/', 'Bukti_belanja::index');
        $routes->post('input_data', 'Bukti_belanja::inputData');
        $routes->post('delete_data', 'Bukti_belanja::deleteData');
    });
});
