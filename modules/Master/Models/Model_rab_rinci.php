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

namespace Modules\Master\Models;

use App\Models\MY_Model;

class Model_rab_rinci extends MY_Model
{
    protected $table = 'ta_rab_rinci';

    function getTaRabRinci($whereArray = null){
        $build = $this->db->table($this->table)->select('*');
        if($whereArray){
            $build->where($whereArray);
        }
        return $build->get();
    }

}
