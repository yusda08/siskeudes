<?php

/** @var TYPE_NAME $routes */
$routes->group('home', ['namespace' => '\Modules\Home\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->post('set_session_tahun', 'Home::setSessionTahun');
});

$routes->group('profile', ['namespace' => '\Modules\Home\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'Profile::index');
    $routes->post('verification-password', 'Profile::verificationPassword');
    $routes->post('update-user', 'Profile::updateUser');
});

$routes->group('login', ['namespace' => '\Modules\Home\Controllers'], function ($routes) {
    $routes->get('/', 'Login::index');
    $routes->get('logout', 'Login::logout');
    $routes->post('validasi_login', 'Login::validasiLogin');
});
