<?php

namespace Modules\Referensi\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Referensi\Models\Model_pegawai;

class Pegawai extends BaseController
{

    //put your code here
    const MODULE = 'Modules\Referensi\Views\pegawai';
    private Model_pegawai $M_Pegawai;

    public function __construct()
    {
        parent::__construct();
        $this->M_Pegawai = new Model_pegawai();
    }

    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['ribbon'] = ribbon('Referensi', 'Pegawai');
        $record['getPegawai'] = $this->M_Pegawai->where('kd_kec', $this->getKdKec())->findAll();
        $this->render($record);
    }

    public final function loadDataPegawai(): \CodeIgniter\HTTP\ResponseInterface
    {
        $nip_nik = $this->post('nip_nik');
        $whereArray = $nip_nik ? ['nip_nik' => $nip_nik] : '';
        $getData = $this->M_Pegawai->where($whereArray)->findAll();
        return $this->setJson($getData);
    }

    public final function inputPegawai(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $id_pegawai = $this->post('id_pegawai');
            $data = [
                'nama_pegawai' => $this->post('nama_pegawai'),
                'jabatan' => $this->post('jabatan'),
                'nip_nik' => $this->post('nip_nik'),
                'no_telpon' => $this->post('no_telpon'),
                'kd_kec' => $this->getKecamatan()['kd_kec'],
            ];
            !$id_pegawai
                ? $this->insert_data('ref_pegawai', $data)
                : $this->update_data('id_pegawai', $id_pegawai, 'ref_pegawai', $data);
            $response = ResponseLib::getStatusTrue('Menambah Data Pegawai');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        $this->flashdata($response['message'], $response['status']);
        return redirect()->back();
    }

    public final function deletePegawai(): \CodeIgniter\HTTP\ResponseInterface
    {

        try {
            $this->cekNotIsAjax();
            $this->cekNotIsPOST();
            cekCsrfToken($this->post('token'));
            $id_pegawai = $this->post('id_pegawai');
            $this->delete_data('id_pegawai', $id_pegawai, 'ref_pegawai');
            $response = ResponseLib::getStatusTrue('Delete Data Pegawai');
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

    /**
     * @throws \Exception
     */
    private function _formValidation(): void
    {
        $rules = [
            'nip_nik' => 'required|is_unique[ref_pegawai.nip_nik]',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'no_telpon' => 'required'
        ];
        if (!$this->validate($rules)) {
            throw new \Exception('Validasi Form Gagal');
        }
    }
}
