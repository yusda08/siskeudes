<?php

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use App\Models;
use App\Models\Model_Auth;

class Login extends BaseController
{
    const MODULE = 'Modules\Home\Views';

    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->M_Auth = new Model_Auth();
        $this->db = db_connect();
    }

    public final function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $view = self::MODULE . '\form_login';
        if (aksesLog()) {
            return redirect()->to(site_url('home'));
        }
        return view($view);
    }

    public final function validasiLogin(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsAjax();
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $username = $this->post('username');
            $password = $this->post('password');
            $username = $this->db->escape($username);
            $row = $this->M_Auth->where('username', str_replace("'", '', $username))->first();
            if (password_verify($password, $row['password'])) {
                if ($row['is_active'] == 1) {
                    $key = random_string('alnum', 64);
                    set_cookie('siskeudes_session', $key, 3600 * 24 * 30);
                    $data = $this->sessionAplikasi($row['kd_level'], $row['kd_user']);
                    session()->set('is_logined', $data);
                    $response = ResponseLib::getStatusTrue('Berhasil Login');
                } else {
                    $response = ResponseLib::getStatusFalse('Status User Belum Aktif');
                }
            } else {
                $response = ResponseLib::getStatusFalse('Password Tidak Sesuai');
            }
        } catch (\Exception $e) {
            $response = ResponseLib::getStatusFalse($e->getMessage());
        }
        return $this->setJson($response);
    }

    public final function logout(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return $this->index();
    }

}