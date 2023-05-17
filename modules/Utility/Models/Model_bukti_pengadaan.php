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

namespace Modules\Utility\Models;

use CodeIgniter\Model;

class Model_bukti_pengadaan extends Model
{

    protected $table = 'uti_bukti_pengadaan';
    protected $primaryKey = 'id_bukti';
    protected $allowedFields = ['uraian','parent','status','input'];

}
