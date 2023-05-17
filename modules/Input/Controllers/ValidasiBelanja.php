<?php

namespace Modules\Input\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Input\Models\Model_data_bukti_belanja;
use Modules\Input\Services\BuktiService;
use Modules\Master\Models\Model_spp;
use Modules\Master\Services\KuitansiService;
use Modules\Referensi\Services\ReferensiService;

class ValidasiBelanja extends BaseController
{

    const MODULE = 'Modules\Input\Views\validation';
    private ReferensiService $S_Referensi;
    private Model_spp $M_Spp;
    private KuitansiService $S_Kuitansi;
    private Model_data_bukti_belanja $M_BktBelanja;
    private BuktiService $S_Bukti;

    public function __construct()
    {
        parent::__construct();
        $this->S_Referensi = new ReferensiService();
        $this->M_Spp = new Model_spp();
        $this->M_BktBelanja = new Model_data_bukti_belanja();
        $this->S_Kuitansi = new KuitansiService();
        $this->S_Bukti = new BuktiService();
    }


    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['ribbon'] = ribbon('Validation', 'SPP');
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDataDesa'] = $this->S_Referensi->getDesaLog($record['row_kec']['kd_kec']);
        $record['getSpp'] = $this->M_Spp->where(['kd_desa' => $record['kd_desa']])->findAll();
        $this->render($record);
    }

    public final function formValidasi(): void
    {
        $record['content'] = self::MODULE . '\form_validation';
        $record['ribbon'] = ribbon('Validasi', ' Form Validasi Bukti');
        $record['no_spp'] = decodeUrl($this->_get('spp'));
        $record['no_bukti'] = decodeUrl($this->_get('bukti'));
        $record['spp'] = $this->M_Spp->where(['no_spp' => $record['no_spp']])->first();
        $record['kuitansi'] = $this->S_Kuitansi->getKuitansiSppFirst($record['spp']['jn_spp'], ['no_bukti' => $record['no_bukti']]);
        $record['getDataBukti'] = $this->M_BktBelanja
            ->where(['no_bukti' => $record['no_bukti']])
            ->join('uti_bukti_belanja', 'id_bukti')
            ->findAll();
        $this->render($record);
    }

    public final function validationBukti(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $this->S_Bukti->validationBukti($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil Verifikasi Bukti');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusTrue($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

    public final function postingValidation(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $this->S_Bukti->postingValidation($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil Posting');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
//        return $this->setJson($response);
        return $response['status']
            ? redirect()->to(site_url('validasi-belanja?desa=' . $this->post('kd_desa')))
            : redirect()->back();
    }

    public final function koreksi(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsPOST();
            $this->S_Bukti->postingBukti($this->request);
            $response = ResponseLib::getStatusTrue('Berhasil koreksi data');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }


}
