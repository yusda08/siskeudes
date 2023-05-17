<?php

namespace Modules\Setting\Models;

use CodeIgniter\Model;

class Model_user_level extends Model
{

    protected $table = 'user_level';
    protected $primaryKey = 'kd_level';
    protected $allowedFields = ['kd_level', 'ket_level'];


}
