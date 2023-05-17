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

$routes->group('referensi', ['namespace' => '\Modules\Referensi\Controllers', 'filter' => 'ceklogin'], function ($routes) {
	$routes->group('pegawai', function ($routes) {
		$routes->get('/', 'Pegawai::index');
		$routes->post('input-pegawai', 'Pegawai::inputPegawai');
		$routes->post('delete', 'Pegawai::deletePegawai');
	});
    $routes->group('kecamatan', function ($routes) {
        $routes->get('/', 'Kecamatan::index');
    });
});