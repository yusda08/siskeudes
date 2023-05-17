<?php

namespace Modules\Setting\Models;

use CodeIgniter\Model;

class Model_user extends Model
{

    protected $table = 'user';
    protected $primaryKey = 'kd_user';
    protected $allowedFields = ['username', 'kd_level', 'password', 'nama_user', 'nip_nik', 'kd_desa', 'is_active', 'is_login'];


}
