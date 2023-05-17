<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author Yusda Helmani
 */

namespace Modules\Setting\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Models\Model_pegawai;
use Modules\Setting\Models\Model_user;
use Modules\Setting\Models\Model_user_level;
use Modules\Setting\Services\UserService;

class User extends BaseController
{
    const MODULE = 'Modules\Setting\Views\user';
    private Model_user $M_User;
    private Model_user_level $M_UserLevel;
    private Model_desa $M_Desa;
    private UserService $S_User;
    private Model_pegawai $M_Pegawai;

    public function __construct()
    {
        parent::__construct();
        $this->M_User = new Model_user();
        $this->M_UserLevel = new Model_user_level();
        $this->M_Desa = new Model_desa();
        $this->M_Pegawai = new Model_pegawai();
        $this->S_User = new UserService();
    }

    public final function index(): void
    {
        $kecamatan = $this->getKecamatan();
        $record['content'] = self::MODULE . '\index';
        $record['kd_level'] = $this->_get('level');
        $record['getUserLevel'] = $this->M_UserLevel->findAll();
        $record['getUser'] = $this->M_User->where('kd_level', $record['kd_level'])->findAll();
        $record['getDesa'] = $this->M_Desa->where('kd_kec', $kecamatan['kd_kec'])->findAll();
        $record['getPegawai'] = $this->M_Pegawai->where('kd_kec', $kecamatan['kd_kec'])->findAll();
        $record['ribbon'] = ribbon('Setting', 'User');
        $this->render($record);
    }

    public final function storeUser(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->cekNotIsPOST();
        cekCsrfToken($this->post('token'));
        $this->_formValidation();
        try {
            $this->S_User->addUser($this->request);
            $response = ResponseLib::getStatusTrue('Menambahkan Data User');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

    private function _formValidation(): void
    {
        $rules = [
            'username' => 'required|is_unique[user.username]',
            'password' => 'required|min_length[6]',
            'nama_user' => 'required',
        ];
        if ($this->validate($rules) === false) {
            $this->flashdata('Validasi Gagal');
        }
    }

    public final function resetPassword(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $kd_user = $this->post('kd_user');
            $data = ['password' => password_hash('123456', PASSWORD_BCRYPT)];
            $this->M_User->update($kd_user, $data);
            $response = ResponseLib::getStatusTrue();
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    function isActive()
    {
        try {
            $kd_user = $this->post('kd_user');
            $data['is_active'] = $this->post('is_active') == 1 ? 0 : 1;
            $que = $this->update_data('kd_user', $kd_user, 'user', $data);
            $msg = ['status' => true, 'ket' => 'Update Status User'];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        return json_encode($msg);
    }

    public final function deleteUser(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsPOST();
            $this->cekNotIsAjax();
            cekCsrfToken($this->post('token'));
            $this->M_User->delete($this->post('kd_user'));
            $response = ResponseLib::getStatusTrue('Delete Status User');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    function getUsername()
    {
        $username = $this->post('username');
        $build = $this->M_User->where('username', $username)->first();
        return json_encode($build);
    }
}
