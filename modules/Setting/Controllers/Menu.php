<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Setting\Controllers;

/**
 * Description of Role_menu
 *
 * @author Yusda Helmani
 */

use App\Controllers\BaseController;
use Modules\Setting\Models as Setting;

class Menu extends BaseController
{
    const MODULE = 'Modules\Setting\Views\menu';
    private Setting\Model_user $M_User;
    private Setting\Model_user_level $M_UserLevel;
    private Setting\Model_menu $M_Menu;

    public function __construct()
    {
        parent::__construct();
        $this->M_User = new Setting\Model_user();
        $this->M_UserLevel = new Setting\Model_user_level();
        $this->M_Menu = new Setting\Model_menu();
    }

    function index()
    {
        $record['content'] = self::MODULE . '\index';
        $record['kd_level'] = $this->_get('level');
        $record['getUserLevel'] = $this->M_UserLevel->findAll();
        $record['getMenu'] = $this->M_Menu->findAll();
        $record['getMenuAkses'] = $this->M_Menu->getMenuRole(['kd_level' => $record['kd_level']])->findAll();
        $record['ribbon'] = ribbon('Setting', 'Menu');
        $this->render($record);
    }

    function inputMenu()
    {
        $this->cekNotIsAjax();
        $this->cekNotIsPOST();
        cekCsrfToken($this->post('token'));
        $parent = $this->post('parent');
        try {
            if ($parent) {
                $data['id_menu'] = $parent;
                $data['kd_level'] = $this->post('kd_level');
                $this->insert_duplicate('menu_role', $data);
            }
            $data['id_menu'] = $this->post('id_menu');
            $data['kd_level'] = $this->post('kd_level');
            $que = $this->insert_duplicate('menu_role', $data);
            $status = $que ? true : false;
            $msg = ['status' => $status, 'ket' => 'Berhasil Input Role Menu'];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        return json_encode($msg);
    }

    function deleteMenu()
    {
        $this->cekNotIsAjax();
        $this->cekNotIsPOST();
        cekCsrfToken($this->post('token'));
        try {
            $column['id_menu'] = $this->post('id_menu');
            $column['kd_level'] = $this->post('kd_level');
            $que = $this->delete_where($column, 'menu_role');
            $status = $que ? true : false;
            $msg = ['status' => $status, 'ket' => 'Berhasil Menghapus Role Menu'];
        } catch (\Throwable $th) {
            $msg = ['status' => false, 'ket' => $th->getMessage()];
        }
        return json_encode($msg);
    }
}
