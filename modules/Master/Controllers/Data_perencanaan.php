<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author Yusda Helmani
 */

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models as Master;
use Modules\Utility\Models as Utility;

class Data_perencanaan extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->M_Bidang = new Master\Model_bidang();
        $this->M_SubBidang = new Master\Model_subbidang();
        $this->M_Keg = new Master\Model_kegiatan();
        $this->M_Rab = new Master\Model_rab();
        $this->M_RabRinci = new Master\Model_rab_rinci();
        $this->M_JnsBlnj = new Utility\Model_jenis_belanja();
    }

    function loadTaBidang(array $arrayWhere = null){
        return $this->M_Bidang->getTaBidang($arrayWhere)->getResultArray();
    }

    function loadTaSubBidang(array $arrayWhere = null){
        return $this->M_SubBidang->getTaSubBidang($arrayWhere)->getResultArray();
    }

    function loadTaKegiatan(array $arrayWhere = null){
        return $this->M_Keg->getTaKegiatan($arrayWhere)->getResultArray();
    }

    function loadTaRab(array $arrayWhere = null){
        return $this->M_Rab->getTaRab($arrayWhere)->getResultArray();
    }

    function loadTaRabRinci(array $arrayWhere = null){
        $getRinci = $this->M_RabRinci->getTaRabRinci($arrayWhere)->getResultArray();
        $getJenis = $this->M_JnsBlnj->findAll();
        foreach ($getRinci as $i => $row) {
            $nama_jenis = '';
            foreach ($getJenis as $jns) {
                if($jns['kd_jenis'] == $row['kd_jenis']){
                    $nama_jenis = $jns['nama_jenis'];
                }
            }
            $getRinci[$i]['nama_jenis'] = $nama_jenis;
        }
        return $getRinci;
    }
}
