<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Integrasi\Controllers;

/**
 * Description of Role_menu
 *
 * @author Yusda Helmani
 */

use App\Controllers\BaseController;
use Modules\Integrasi\Controllers as C_Integrasi;
use Modules\Integrasi\Models as Integrasi;
use Modules\Referensi\Models as M_Ref;

class Spp_spj extends BaseController
{

    //put your code here

    var $module = 'Modules\Integrasi\Views';
    var $moduleUrl = 'integrasi/spp_spj';

    public function __construct()
    {
        parent::__construct();
        $this->DataApi = new C_Integrasi\Data_Api();
        $this->M_Tarik = new Integrasi\M_Tarik();
        $this->M_Kec = new M_Ref\Model_kecamatan();
    }

    function index()
    {
        $record['content'] = $this->module . '\spp_spj\index';
        $record['moduleUrl'] = $this->moduleUrl;
        $record['row_kec'] = $this->getKecamatan();
        $record['ribbon'] = ribbon('Integrasi', 'Data SPP dan SPJ');
        $this->render($record);
    }

    function inputDataSpp()
    {
        $this->cekNotIsAjax();
        $tahun = $this->getTahun();
        $kd_kec = $this->post('kd_kec');
        try {
            $getData = $this->DataApi->getSpp($tahun, $kd_kec)['result'];
//            echo json_encode($getData);
//            die();
            $status = $this->M_Tarik->saveSpp($getData);
            $msg = ['status' => true, 'msg' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'msg' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

    function inputDataSpj()
    {
        $this->cekNotIsAjax();
        $tahun = $this->getTahun();
        $kd_kec = $this->post('kd_kec');
        try {
            $getData = $this->DataApi->getSpj($tahun, $kd_kec)['result'];
            $status = $this->M_Tarik->saveSpj($getData);
            $msg = ['status' => true, 'msg' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'msg' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

}
