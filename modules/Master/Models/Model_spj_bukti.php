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


use CodeIgniter\Model;

class Model_spj_bukti extends Model
{
    protected $table = 'ta_spj_bukti';
    protected $primaryKey = 'no_bukti';

//    function getSpjBukti($whereArray = null){
//        $build = $this->select($this->table.'*, no_spp')
//            ->join('ta_spj', 'a.no_spj=b.no_spj');
//        if($whereArray){
//            $build->where($whereArray);
//        }
//        return $build->findAll();
//    }

}
