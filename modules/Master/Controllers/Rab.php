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
use App\Libraries\ResponseLib;
use Modules\Master\Controllers as C_Master;
use Modules\Master\Services\MasterService;
use Modules\Referensi\Models as Referensi;

class Rab extends BaseController
{

    protected $module = 'Modules\Master\Views';
    protected $moduleUrl = 'master/rab';
    private MasterService $S_Master;

    public function __construct()
    {
        parent::__construct();
        $this->M_Kec = new Referensi\Model_kecamatan();
        $this->Data = new C_Master\Data_perencanaan();
        $this->S_Master = new MasterService();
    }

    function index()
    {
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->_get('desa');
        $record['kd_bidang'] = $this->_get('bidang');
        $record['kd_subbid'] = $this->_get('subbidang');
        $record['getDataDesa'] = $this->M_Kec->getDesa(['kd_kec' => $record['row_kec']['kd_kec']])->getResultArray();
        $record['getTaBidang'] = $this->Data->loadTaBidang(['tahun' => $this->getTahun()]);
        $record['getTaSubBidang'] = $this->Data->loadTaSubBidang(['tahun' => $this->getTahun()]);
        $record['getTaKegiatan'] = $this->Data->loadTaKegiatan(['tahun' => $this->getTahun()]);
        $record['moduleUrl'] = $this->moduleUrl;
        $record['content'] = $this->module . '\perencanaan\index';
        $record['ribbon'] = ribbon('Master', 'Perencanaan');
        $this->render($record);
    }

    function rab()
    {
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->_get('desa');
        $record['kd_bidang'] = $this->_get('bidang');
        $record['kd_subbid'] = $this->_get('subbidang');
        $record['getDataDesa'] = $this->M_Kec->getDesa(['kd_kec' => $record['row_kec']['kd_kec']])->getResultArray();
        $record['getTaBidang'] = $this->Data->loadTaBidang(['tahun' => $this->getTahun()]);
        $record['getTaSubBidang'] = $this->Data->loadTaSubBidang(['tahun' => $this->getTahun()]);
        $record['getTaKegiatan'] = $this->Data->loadTaKegiatan(['tahun' => $this->getTahun()]);
        $record['moduleUrl'] = $this->moduleUrl;
        $record['content'] = $this->module . '\perencanaan\index';
        $record['ribbon'] = ribbon('Master', 'Perencanaan');
        $this->render($record);
    }

    function loadTaBidang()
    {
        $this->cekNotIsAjax();
        $getData = $this->Data->loadTaBidang(['tahun' => $this->getTahun(), 'kd_desa' => $this->get('desa')]);
        echo json_encode($getData);
    }

    function loadTaSubbidang()
    {
        $this->cekNotIsAjax();
        $getData = $this->Data->loadTaSubBidang(['tahun' => $this->getTahun(), 'kd_bid' => $this->get('bidang')]);
        echo json_encode($getData);
    }

    public final function loadAnggaran(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $log = aksesLog();
            $array = $log['kd_desa'] ? ['kd_desa' => $log['kd_desa']] : [];
            $getData = $this->S_Master->getAnggaran($array);
            foreach ($getData as $i => $data) {
                $getData[$i]['anggaran'] = (int)$data['anggaran'];
            }
            $response = ResponseLib::getStatusTrue(data: $getData);
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    public final function loadAnggaranDesa(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $log = aksesLog();
            $array = $log['kd_desa'] ? ['kd_desa' => $log['kd_desa']] : [];
            $getData = $this->S_Master->getAnggaranDesa($array);
            foreach ($getData as $i => $data) {
                $getData[$i]['anggaran'] = (int)$data['anggaran'];
            }
            $response = ResponseLib::getStatusTrue(data: $getData);
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

}
