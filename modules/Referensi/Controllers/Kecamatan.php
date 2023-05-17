<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Referensi\Controllers;

/**
 * Description of Role_menu
 *
 * @author Yusda Helmani
 */

use App\Controllers\BaseController;
use Modules\Referensi\Models as M_Ref;

class Kecamatan extends BaseController
{

    //put your code here
    const MODULE = 'Modules\Referensi\Views\kecamatan';
    private M_Ref\Model_desa $M_Desa;

    public function __construct()
    {
        parent::__construct();
        $this->M_Kec = new M_Ref\Model_kecamatan();
        $this->M_Desa = new M_Ref\Model_desa();
    }

    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['ribbon'] = ribbon('Referensi', 'Kecamatan');
        $record['row_kec'] = $this->M_Kec->where('status_app', 1)->first();
        $record['getDesa'] = $this->M_Desa->where('kd_kec', $record['row_kec']['kd_kec'])->findAll();
        $this->render($record);
    }

}
