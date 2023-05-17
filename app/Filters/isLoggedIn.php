<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of isLoggedIn
 *
 * @author Yusda Helmani
 */

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class isLoggedIn implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        $auth = session()->get('is_logined');
        if (!$auth) {
            return redirect()->to(site_url('login'));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
