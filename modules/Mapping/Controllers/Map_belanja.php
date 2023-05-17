<?php

namespace Modules\Mapping\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Mapping\Models as Mapping;
use Modules\Referensi\Models as Referensi;
use Modules\Utility\Models as Utility;

class Map_belanja extends BaseController
{
    private $module = 'Modules\Mapping\Views';
    private $moduleUrl = 'mapping/belanja';
    private Mapping\Model_mapping_bukti_belanja $M_MapBelanja;

    public function __construct()
    {
        parent::__construct();
        $this->M_MapBelanja = new Mapping\Model_mapping_bukti_belanja();
        $this->M_Rek4 = new Referensi\Model_ref_rek4();
        $this->M_BuktiBelanja = new Utility\Model_bukti_belanja();
    }

    function index()
    {
        $record['content'] = $this->module . '\belanja\index';
        $record['moduleUrl'] = $this->moduleUrl;
        $record['getRefRek4'] = $this->M_Rek4->findAll();
        $record['getBuktiBelanja'] = $this->M_BuktiBelanja->findAll();
        $record['getMapBelanja'] = $this->M_MapBelanja->getMapBelanja(['tahun' => $this->getTahun(), 'kd_kec' => $this->getKdKec()]);
        $record['ribbon'] = ribbon('Mapping', 'Bukti Belanja');
        $this->render($record);
    }

    public final function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            $this->cekNotIsPost();
            cekCsrfToken($this->post('token'));
            $bukti = $this->post('id_bukti[]');
            foreach ($bukti as $i => $bkt) {
                $b = explode('.', $bkt);
                $data['id_bukti'] = $b[0];
                $data['nama_bukti'] = $b[1];
                $data['kd_rincian'] = $this->post('kd_rincian');
                $data['kd_kec'] = $this->getKdKec();
                $data['tahun'] = $this->getTahun();
                $this->M_MapBelanja->replace($data);
            }
            $msg = ['status' => true, 'ket' => 'Berhasil Input Data'];
        } catch (\Exception $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        $this->flashdata($msg['ket'], $msg['status']);
        return redirect()->back();
    }

    public final function delete(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsPOST();
            $this->cekNotIsAjax();
            cekCsrfToken($this->post('token'));
            $id = $this->post('map_id');
            $this->M_MapBelanja->delete($id);
            $response = ResponseLib::getStatusTrue('Delete data berhasil');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

}
