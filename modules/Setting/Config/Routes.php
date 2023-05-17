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
$routes->group('setting', ['namespace' => '\Modules\Setting\Controllers', 'filter' => 'ceklogin'], function ($routes) {
    $routes->group('user', function ($routes) {
        $routes->get('/', 'User::index');
        $routes->post('add-user', 'User::storeUser');
        $routes->post('reset_password', 'User::resetPassword');
        $routes->post('delete_user', 'User::deleteUser');
        $routes->post('is_active', 'User::isActive');
        $routes->post('get_username', 'User::getUsername');
    });
    $routes->group('menu', function ($routes) {
        $routes->get('/', 'Menu::index');
        $routes->post('input_menu', 'Menu::inputMenu');
        $routes->post('delete_menu', 'Menu::deleteMenu');
    });

    $routes->group('posting', function ($routes) {
        $routes->get('/', 'PostingKuitansi::index');
        $routes->post('cancel', 'PostingKuitansi::cancelKuitansi');
    });
});
