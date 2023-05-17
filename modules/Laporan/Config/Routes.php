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

$routes->group('laporan', ['namespace' => '\Modules\Laporan\Controllers'], function ($routes) {
    $routes->group('kartu_kendali', function($routes) {
        $routes->get('/', 'Kartu_kendali::index', ['filter' => 'ceklogin']);
        $routes->get('cetak_kartu_kendali', 'Kartu_kendali::cetakKartuKendali');
        $routes->get('cetak_kartu_kendali_empty', 'Kartu_kendali::cetakKartuKendaliEmpty');
    });

    $routes->group('disposisi', function($routes) {
        $routes->get('/', 'Disposisi::index', ['filter' => 'ceklogin']);
        $routes->get('cetak_lembar_disposisi', 'Disposisi::cetakLembarDisposisi');
        $routes->get('cetak_lembar_disposisi_empty', 'Disposisi::cetakLembarDisposisiEmpty');
    });

    $routes->group('surat_keluar', function($routes) {
        $routes->get('/', 'Lap_surat_keluar::index', ['filter' => 'ceklogin']);
        $routes->get('surat_keluar_pdf', 'Lap_surat_keluar::suratKeluarPdf');
        $routes->post('load_surat_keluar', 'Lap_surat_keluar::loadSuratKeluar', ['filter' => 'ceklogin']);
    });
});
