<?php

namespace Modules\Mapping\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Mapping\Models\Model_mapping_pegawai_desa;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Models\Model_pegawai;

class Map_pegawai extends BaseController
{
    const MODULE = 'Modules\Mapping\Views\pegawai';
    private Model_pegawai $M_Pegawai;
    private Model_desa $M_Desa;
    private Model_mapping_pegawai_desa $M_MapPgwDesa;

    public function __construct()
    {
        parent::__construct();
        $this->M_Pegawai = new Model_pegawai();
        $this->M_Desa = new Model_desa();
        $this->M_MapPgwDesa = new Model_mapping_pegawai_desa();
    }

    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['getPegawai'] = $this->M_Pegawai->findAll();
        $record['getDesa'] = $this->M_Desa->where('kd_kec', $this->getKdKec())->findAll();
        $record['getMapPgwDesa'] = $this->M_MapPgwDesa->getMapPegawaiDesa(['ref_pegawai.kd_kec' => $this->getKdKec()])->findAll();
        $record['ribbon'] = ribbon('Mapping', 'Pegawai Desa');
        $this->render($record);
    }

    public final function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            $this->cekNotIsPost();
            cekCsrfToken($this->post('token'));
            $kdDesa = $this->post('kd_desa[]');
            foreach ($kdDesa as $i => $desa) {
                $data['kd_desa'] = $desa;
                $data['nip_nik'] = $this->post('nip_nik');
                $this->M_MapPgwDesa->insert($data);
            }
            $response = ResponseLib::getStatusTrue('Berhasil Input Data');
        } catch (\Exception $th) {
            $response = ResponseLib::getStatusTrue($th->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

    public final function delete(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $this->cekNotIsPOST();
            $this->cekNotIsAjax();
            cekCsrfToken($this->post('token'));
            $id = $this->post('map_id');
            $this->M_MapPgwDesa->delete($id);
            $response = ResponseLib::getStatusTrue('Delete data berhasil');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }



}
