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
use Modules\Master\Controllers as C_Master;
use Modules\Referensi\Models as Referensi;

class Perencanaan extends BaseController
{

    protected $module = 'Modules\Master\Views';
    protected $moduleUrl = 'master/perencanaan';
    private Referensi\Model_desa $M_Desa;

    public function __construct()
    {
        parent::__construct();
        $this->M_Kec = new Referensi\Model_kecamatan();
        $this->M_Desa = new Referensi\Model_desa();
        $this->Data = new C_Master\Data_perencanaan();
    }

    function index()
    {
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->_get('desa');
        $record['kd_bidang'] = $this->_get('bidang');
        $record['kd_subbid'] = $this->_get('subbidang');
        $record['getDataDesa'] = $this->M_Desa->where(['kd_kec' => $record['row_kec']['kd_kec']])->findAll();
        $record['getTaBidang'] = $this->Data->loadTaBidang(['tahun' => $this->getTahun()]);
        $record['getTaSubBidang'] = $this->Data->loadTaSubBidang(['tahun' => $this->getTahun()]);
        $record['getTaKegiatan'] = $this->Data->loadTaKegiatan(['tahun' => $this->getTahun()]);
        $record['moduleUrl'] = $this->moduleUrl;
        $record['content'] = $this->module . '\perencanaan\index';
        $record['ribbon'] = ribbon('Master', 'Kodefikasi Belanja');
        $this->render($record);
    }

    function rab()
    {
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->_get('desa');
        $record['kd_keg'] = $this->_get('kegiatan');
        $record['array'] = $this->getKode($record['kd_keg']);
        $record['getTaKegiatan'] = $this->Data->loadTaKegiatan(['tahun' => $this->getTahun(), 'kd_keg' => $record['kd_keg']]);
        $record['getTaRab'] = $this->Data->loadTaRab(['tahun' => $this->getTahun(), 'kd_keg' => $record['kd_keg']]);
        $record['getTaRabRinci'] = $this->Data->loadTaRabRinci(['tahun' => $this->getTahun(), 'kd_keg' => $record['kd_keg']]);
        $record['moduleUrl'] = $this->moduleUrl;
        $record['content'] = $this->module . '\perencanaan\view_rab';
        $record['ribbon'] = ribbon('Master', 'Perencanaan');
        $this->render($record);
    }

    function updateJenisBelanja()
    {
//        $this->cekNotIsAjax();
        cekCsrfToken($this->post('token'));
        try {
            $column['tahun'] = $this->getTahun();
            $column['kd_desa'] = $this->post('kd_desa');
            $column['kd_keg'] = $this->post('kd_keg');
            $column['kd_rincian'] = $this->post('kd_rincian');
            $column['kd_subrinci'] = $this->post('kd_subrinci');
            $column['no_urut'] = $this->post('no_urut');
            $data['kd_jenis'] = $this->post('kd_jenis');
            $query = $this->update_where($column, 'ta_rab_rinci', $data);
            $status = $query ? true : false;
            $msg = ['status' => $status, 'ket' => 'Update Berhasil'];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        return json_encode($msg);
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

}
