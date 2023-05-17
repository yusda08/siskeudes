<?php

namespace Modules\Utility\Controllers;

use App\Controllers\BaseController;
use Modules\Utility\Models as Utility;

class Bukti_belanja extends BaseController
{
    private $module = 'Modules\Utility\Views';
    private $moduleUrl = 'utility/bukti_belanja';

    public function __construct()
    {
        parent::__construct();
        $this->M_BuktiBelanja = new Utility\Model_bukti_belanja();
    }

    function index()
    {
        $record['content'] = $this->module . '\bukti_belanja\index';
        $record['moduleUrl'] = $this->moduleUrl;
        $record['getBuktiBelanja'] = $this->M_BuktiBelanja->findAll();
        $record['ribbon'] = ribbon('Utility', 'Bukti Belanja');
        $this->render($record);
    }

    function inputData()
    {
        $this->cekNotIsPost();
        cekCsrfToken($this->post('token'));
        try {
            $rules = ['uraian' => 'required'];
            if (!$this->validate($rules)) {
                $this->flashdata('Validasi Form Gagal', false);
                return redirect()->back()->withInput('validation', $this->validasi);
            }
            $data['uraian'] = $this->post('uraian');
            $query = $this->insert_data('uti_bukti_belanja', $data);
            $status = $query ? true : false;
            $ket = 'Input Data Bukti Belanja';
        } catch (\Exception $th) {
            $ket = $th->getMessage();
            $status = false;
        }
        $this->flashdata($ket, $status);
        return redirect()->back();
    }

    function deleteData()
    {
        $this->cekNotIsPOST();
        $this->cekNotIsAjax();
        cekCsrfToken($this->post('token'));
        try {
            $column['id_bukti'] = $this->post('id_bukti');
            $this->delete_where($column, 'uti_bukti_belanja');
            $msg = ['status' => true, 'ket' => 'Delete Data Berhasil'];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        echo json_encode($msg);
    }

}
