<?php

namespace Modules\Master\Models;

use CodeIgniter\Model;

class Model_subbidang extends Model
{
    protected $table = 'ta_subbidang';

    function getTaSubBidang($whereArray = null){
        $build = $this->db->table($this->table)->select('*');
        if($whereArray){
            $build->where($whereArray);
        }
        return $build->get();
    }

}
