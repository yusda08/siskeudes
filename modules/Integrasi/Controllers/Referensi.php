<?php

namespace Modules\Integrasi\Controllers;

use App\Controllers\BaseController;
use Modules\Integrasi\Controllers as C_Integrasi;
use Modules\Integrasi\Models as Integrasi;

class Referensi extends BaseController
{

    //put your code here

    var $module = 'Modules\Integrasi\Views';
    var $moduleUrl = 'integrasi/referensi';

    public function __construct()
    {
        parent::__construct();
        $this->DataApi = new C_Integrasi\Data_Api();
        $this->M_Tarik = new Integrasi\M_Tarik();
    }

    function index()
    {
        $record['content'] = $this->module . '\referensi\index';
        $record['ribbon'] = ribbon('Integrasi', 'Data Referensi');
        $this->render($record);
    }

    function inputDataRekening()
    {
        $this->cekNotIsAjax();
        try {
            $getData = $this->DataApi->getRekening()['result'];
            $status = $this->M_Tarik->saveRekening($getData);
            $msg = ['status' => $status, 'msg' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'msg' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

    function inputDataLokasi()
    {
        $this->cekNotIsAjax();
        try {
            $getData = $this->DataApi->getLokasi()['result'];
            $status = $this->M_Tarik->saveLokasi($getData);
            $msg = ['status' => $status, 'msg' => 'Berhasil Integrasi Data', 'data' => (array)$getData];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'msg' => $th->getMessage(), 'data' => []];
        }
        return json_encode($msg);
    }

}
