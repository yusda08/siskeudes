<?php

namespace Modules\Setting\Services;


use CodeIgniter\HTTP\Request;
use Modules\Setting\Models\Model_user;

class UserService
{

    private Model_user $M_User;

    public function __construct()
    {
        $this->M_User = new Model_user();
    }

    /**
     * @throws \ReflectionException
     */
    public final function addUser(Request $request): object|bool|int|string
    {
        $data = [
            'username' => $request->getPost('username'),
            'kd_level' => $request->getPost('kd_level'),
            'nip_nik' => $request->getPost('nip_nik'),
            'kd_desa' => $request->getPost('kd_desa'),
            'nama_user' => $request->getPost('nama_user'),
            'password' => password_hash($request->getPost('password'), PASSWORD_BCRYPT),
        ];
        return $this->M_User->insert($data);
    }

}