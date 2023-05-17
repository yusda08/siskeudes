<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class Model_spp extends Model
{
    protected $table = 'ta_spp';
    protected $primaryKey = 'no_spp';
    protected $allowedFields = ['kd_desa', 'tahun', 'tgl_spp', 'jn_spp', 'keterangan', 'jumlah', 'potongan', 'status'];
//    protected $allowedFields = ['kd_desa', 'tahun', 'tgl_spp', 'tgl_spj', 'keterangan', 'jumlah', 'potongan', 'status', 'kunci'];

}
