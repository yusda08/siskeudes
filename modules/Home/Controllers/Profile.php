<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use App\Models\Model_Auth;
use Modules\Setting\Models\Model_user;

class Profile extends BaseController
{

    //put your code here

    const MODULE = 'Modules\Home\Views';
    private Model_user $M_User;

    public function __construct()
    {
        parent::__construct();
        $this->log = aksesLog();
        $this->M_User = new Model_user();
    }

    public final function index(): void
    {
        $record['log'] = aksesLog();
        $record['ribbon'] = ribbon('Home', 'Profile');
        $record['content'] = self::MODULE . '\view_profile';
        $this->render($record);
    }

    public final function verificationPassword(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            cekCsrfToken($this->post('token'));
            $pass = $this->post('password');
            $log = aksesLog();
            $row = $this->M_User->find($log['kd_user']);
            $response = password_verify($pass, $row['password'])
                ? ResponseLib::getStatusTrue()
                : ResponseLib::getStatusFalse('Gagal');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    public final function updateUser(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            cekCsrfToken($this->post('token'));
            $pass = $this->post('password');
            $log = aksesLog();
            $row = $this->M_User->find($log['kd_user']);
            if (!$row) throw new \Exception('User Tidak ditemukan');
            if (!password_verify($pass, $row['password'])) throw new \Exception('Password tidak sesuai');
            $data['nama_user'] = $this->post('nama_user');
            $data['password'] = password_hash($this->post('password_new'), PASSWORD_BCRYPT);
            $this->M_User->update($row['kd_user'], $data);
            $response = ResponseLib::getStatusTrue();
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

}
