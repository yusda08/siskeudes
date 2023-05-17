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

namespace Modules\Input\Models;

use CodeIgniter\Model;

class Model_data_bukti_belanja extends Model
{
    protected $table = 'data_bukti_belanja';
    protected $primaryKey = 'id_bukti_belanja';
    protected $allowedFields = ['id_bukti', 'no_bukti', 'tahun', 'kd_desa', 'kd_rincian', 'file_name', 'file_path', 'file_path', 'catatan_validasi', 'status_bukti', 'status_validasi'];

//    public final function getDataBuktiBelanja(array $whereArray = []): bool|string|\CodeIgniter\Database\ResultInterface
//    {
//        $build = $this->db->table($this->table)->select('*');
//        if ($whereArray) {
//            $build->where($whereArray);
//        }
//        return $build->get();
//    }

}
