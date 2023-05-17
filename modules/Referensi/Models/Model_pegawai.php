<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_setting
 *
 * @author Yusda Helmani
 */

namespace Modules\Referensi\Models;

use App\Models\MY_Model;

class Model_pegawai extends MY_Model
{
    protected $table = 'ref_pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $allowedFields = ['nip_nik', 'nama_pegawai', 'kd_kec', 'jabatan', 'no_telpon'];
}
