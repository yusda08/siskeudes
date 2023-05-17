<?php

namespace Modules\Input\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Input\Models\Model_data_bukti_belanja;
use Modules\Input\Services\BuktiService;
use Modules\Mapping\Models\Model_mapping_bukti_belanja;
use Modules\Master\Models\Model_spp;
use Modules\Master\Services\KuitansiService;
use Modules\Referensi\Models\Model_kecamatan;
use Modules\Referensi\Services\ReferensiService;

class Belanja extends BaseController
{

    const MODULE = 'Modules\Input\Views\belanja';
    private Model_spp $M_Spp;
    private Model_data_bukti_belanja $M_BktBelanja;
    private KuitansiService $S_Kuitansi;
    private BuktiService $S_Bukti;
    private ReferensiService $S_Referensi;
    private Model_mapping_bukti_belanja $M_MapBelanja;

    public function __construct()
    {
        parent::__construct();
        $this->M_Spp = new Model_spp();
        $this->M_BktBelanja = new Model_data_bukti_belanja();
        $this->M_Kec = new Model_kecamatan();
        $this->M_MapBelanja = new Model_mapping_bukti_belanja();
        $this->S_Kuitansi = new KuitansiService();
        $this->S_Bukti = new BuktiService();
        $this->S_Referensi = new ReferensiService();

    }


    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['ribbon'] = ribbon('Input', ' Kelengkapan SPJ');
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDataDesa'] = $this->S_Referensi->getDesaLog($record['row_kec']['kd_kec']);
        $record['getSpp'] = $this->M_Spp->where(['kd_desa' => $record['kd_desa']])->findAll();
        $this->render($record);
    }

    public final function kuitansi(): void
    {
        $record['content'] = self::MODULE . '\view_kuitansi';
        $record['ribbon'] = ribbon('Input', ' Kelengkapan SPJ Kuitansi');
        $record['no_spp'] = decodeUrl($this->_get('spp'));
        $record['spp'] = $this->M_Spp->where(['no_spp' => $record['no_spp']])->first();
        $record['getKuitansi'] = $this->S_Kuitansi->getKuitansiSppFindAll($record['spp']['jn_spp'], ['no_spp' => $record['no_spp']]);
        $this->render($record);
    }

    public final function addBukti(): void
    {
        $record['content'] = self::MODULE . '\add_kuitansi';
        $record['ribbon'] = ribbon('Input', ' Form Input Bukti');
        $record['no_spp'] = decodeUrl($this->_get('spp'));
        $record['no_bukti'] = decodeUrl($this->_get('bukti'));
        $record['spp'] = $this->M_Spp->where(['no_spp' => $record['no_spp']])->first();
        $record['kuitansi'] = $this->S_Kuitansi->getKuitansiSppFirst($record['spp']['jn_spp'], ['no_bukti' => $record['no_bukti']]);
        $record['getDataBukti'] = $this->M_BktBelanja
            ->where(['no_bukti' => $record['no_bukti']])
            ->join('uti_bukti_belanja', 'id_bukti')
            ->findAll();
        $record['getMapBelanja'] = $this->M_MapBelanja->getMapBelanjaWhereIn(['tahun' => $this->getTahun(), 'kd_rincian' => $record['kuitansi']['kd_rincian']]);
        $this->render($record);
    }

    public final function storeBukti(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->cekNotIsPOST();
        cekCsrfToken($this->post('token'));
        try {
            $this->S_Bukti->addBukti($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil Upload Bukti');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusTrue($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

    public final function deleteBukti(): \CodeIgniter\HTTP\ResponseInterface
    {
        $this->cekNotIsAjax();
        $this->cekNotIsPOST();
        cekCsrfToken($this->post('token'));
        try {
            $this->S_Bukti->deleteBukti($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil Menghapus Data');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    public final function postingBukti(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsAjax();
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $this->S_Bukti->postingBukti($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil Posting');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }


}
