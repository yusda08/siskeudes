<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_setting
 *
 * @author Yusda Helmani
 */

namespace Modules\Setting\Models;

use CodeIgniter\Model;

class Model_menu extends Model
{

    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $allowedFields = [''];

    /**
     * @throws \Exception
     */
    public final function getMenuAkses(int $kd_level): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->db->query("SELECT b.* FROM menu b where id in(select id_menu from menu_role a where a.kd_level=$kd_level) order by parent, urutan asc");
    }

    public final function getMenuRole(array $arrayWhere = null): Model_menu
    {
        $build = $this->join('menu_role', 'id=id_menu');
        if ($arrayWhere) {
            $build->where($arrayWhere);
        }
        return $build;
    }
}
