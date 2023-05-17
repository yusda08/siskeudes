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

class Model_kecamatan extends MY_Model
{
    protected $table = 'ref_kecamatan';
    protected $primaryKey = 'id_kec';
    protected $allowedFields = ['kd_kec', 'nama_kecamatan', 'status_app'];

//    function getDesa($arrayWhere = null){
//         $builder = $this->db->table('ref_desa')->select('*');
//        if($arrayWhere){
//            $builder->where($arrayWhere);
//        }
//        return $builder->get();
//    }
}
