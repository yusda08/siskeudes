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

namespace Modules\Setting\Controllers;

use App\Controllers\BaseController;
use Modules\Setting\Models;

class User_group extends BaseController
{

    var $log;
    protected $tabel = 'user_previliges';
    private $module = 'Modules\Setting\Views';
    private $moduleUrl = 'setting/user_group';

    public function __construct()
    {
        parent::__construct();
        $this->log = aksesLog();
        $this->M_User = new Models\Model_user();
        $this->M_Prev = new Models\Model_previliges();

    }

    function index()
    {
        $view = $this->module . '\view_user_group';
        $record = $this->javasc_back();
        $record['moduleUrl'] = $this->moduleUrl;
        $record['getLevelUser'] = $this->M_Prev->findAll();
        $data = $this->layout_back($view, $record);
        $data['ribbon_left'] = ribbon_left('Setting', 'Group User');
        $data['ribbon_right'] = ribbon_right($this->log['job']);
        return $this->backend($data);
    }

    function loadUser()
    {
        $kd_level = $this->post('kd_level');
        $getUserPreviliges = $this->M_User->getUser()->getResultArray();
        $data = "<option value=''>-- Pilih User --</option>";
        foreach ($getUserPreviliges as $row) {
            if ($kd_level == $row['kd_level']) {
                $data .= "<option value='{$row['kd_user']}'>{$row['nama_user']}</option>";
            }
        }
        echo $data;
    }

    function loadStruktur()
    {
        $kd_level = $this->post('kd_level');
        if ($kd_level == 2 or $kd_level == 3 or $kd_level == 4 or $kd_level == 5) {
            $getDataJabatan = $this->M_Ref->getDataJabatan()->getResultArray();
            $data = "<option value=''>-- Pilih Jabatan --</option>";
            foreach ($getDataJabatan as $row) {
                $data .= "<option value='{$row['kd_jabatan']}'>{$row['nama_jabatan']}</option>";
            }
        } elseif ($kd_level == 6) {

        }
        echo $data;
    }

    function loadGroupUser()
    {
        $getUserGroup = $this->M_User->getUser()->getResultArray();
        $data = array();
        $no = $_POST['start'];
        foreach ($getUserGroup as $key) {
            if (!is_null($key['kode_group'])) {
                $attrHps = 'onclick="hapusGroupUser(\'' . $key['kode_group'] . '\',\'' . $key['kd_user'] . '\', \'' . $key['nama_user'] . '\')"';
                $btnHapus = "<button {$attrHps} class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>";
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $key['ket_level'];
                $row[] = $key['nama_user'];
                $row[] = $btnHapus;
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => count_allTable('user_group', array()),
            "recordsFiltered" => $this->M_User->count_filtered_user(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function insertGroupUser()
    {
        $token = $this->post('token');
        cekCsrfToken($token);
        $info = false;
        try {
            $ket = 'Menambahkan Data Group User';
            $data['kode_group'] = $this->post('kode_group');
            $data['kd_user'] = $this->post('kd_user');
            $que = $this->insert_duplicate('user_group', $data);
            $info = $que ? true : false;
        } catch (\Throwable $th) {
            $ket = $th->getMessage();
        }
        $this->flashdata($ket, $info);
        return redirect()->back();
    }

    function deleteGroupUser()
    {
        $column['kode_group'] = $this->post('kode_group');
        $column['kd_user'] = $this->post('kd_user');
        $que = $this->delete_where($column, 'user_group');
        $ket = 'Menghapus Data Group User';
        if ($que) {
            echo 'true';
            aktifitas($ket, json_encode($column));
        } else {
            echo 'false';
        }
    }

}
