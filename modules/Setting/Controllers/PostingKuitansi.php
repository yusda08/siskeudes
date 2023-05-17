<?php

namespace Modules\Setting\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Input\Models\Model_data_bukti_kuitansi;
use Modules\Master\Models\Model_spp;
use Modules\Referensi\Services\ReferensiService;

class PostingKuitansi extends BaseController
{

    const MODULE = 'Modules\Setting\Views\posting';
    private ReferensiService $S_Referensi;
    private Model_spp $M_Spp;
    private Model_data_bukti_kuitansi $M_BuktiKuitansi;

    public function __construct()
    {
        parent::__construct();
        $this->S_Referensi = new ReferensiService();
        $this->M_Spp = new Model_spp();
        $this->M_BuktiKuitansi = new Model_data_bukti_kuitansi();
    }

    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['ribbon'] = ribbon('Setting', 'Posting Kuitansi');
        $record['row_kec'] = $this->getKecamatan();
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDataDesa'] = $this->S_Referensi->getDesaLog($record['row_kec']['kd_kec']);
        $record['getSpp'] = $this->M_Spp->where(['kd_desa' => $record['kd_desa']])->findAll();
        $this->render($record);
    }

    public final function cancelKuitansi(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $id = $this->post('id_bukti_kuitansi');
            $data = [
                'status_kuitansi' => 0,
                'status_validasi' => 0,
            ];
            $this->M_BuktiKuitansi->update($id, $data);
            $response = ResponseLib::getStatusTrue();
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

}