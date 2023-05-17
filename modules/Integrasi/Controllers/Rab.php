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

class Rab extends BaseController
{

    //put your code here

    var $module = 'Modules\Integrasi\Views';
    var $moduleUrl = 'integrasi/rab';

    public function __construct()
    {
        parent::__construct();
        $this->DataApi = new C_Integrasi\Data_Api();
        $this->M_Tarik = new Integrasi\M_Tarik();
        $this->M_Kec = new M_Ref\Model_kecamatan();
    }

    function index()
    {
        $record['content'] = $this->module . '\rab\index';
        $record['moduleUrl'] = $this->moduleUrl;
        $record['row_kec'] = $this->getKecamatan();
        $record['ribbon'] = ribbon('Integrasi', 'Data RAB');
        $this->render($record);
    }

    function inputDataPerencanaan()
    {
        $this->cekNotIsAjax();
        $tahun = $this->getTahun();
        $kd_kec = $this->post('kd_kec');
        try {
            $getData = $this->DataApi->getPerencanaanBidang($tahun, $kd_kec)['result'];
            $this->M_Tarik->savePerencanaanBidang($getData);
            $msg = ['status' => true, 'msg' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Exception $th) {
            $msg = ['status' => false, 'msg' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

    public final function inputDataRab()
    {
        $this->cekNotIsAjax();
        $tahun = $this->getTahun();
        $kd_kec = $this->post('kd_kec');
        try {
            $getData = $this->DataApi->getRab($tahun, $kd_kec)['result'];
//            $getDataRinc = $this->DataApi->getRabRinc($tahun, $kd_kec);
            $status = $this->M_Tarik->saveRab($getData);
            $msg = ['status' => $status, 'ket' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Exception $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

}
