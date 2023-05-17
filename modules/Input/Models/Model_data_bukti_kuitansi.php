<?php

namespace Modules\Input\Models;

use CodeIgniter\Model;

class Model_data_bukti_kuitansi extends Model
{
    protected $table = 'data_bukti_kuitansi';
    protected $primaryKey = 'id_bukti_kuitansi';
    protected $allowedFields = ['no_bukti', 'status_kuitansi', 'status_validasi'];

}
