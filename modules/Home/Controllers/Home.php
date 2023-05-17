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

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Services\KuitansiService;
use Modules\Master\Services\MasterService;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Models\Model_ref_rek2;

class Home extends BaseController
{
    const MODULE = 'Modules\Home\Views';
    private Model_ref_rek2 $M_Rek2;
    private MasterService $S_Master;
    private Model_desa $M_Desa;
    private KuitansiService $S_Kuitansi;

    public function __construct()
    {
        parent::__construct();
        $this->M_Rek2 = new Model_ref_rek2();
        $this->S_Master = new MasterService();
        $this->S_Kuitansi = new KuitansiService();
        $this->M_Desa = new Model_desa();
    }

    public final function index(): void
    {
        $record['log'] = aksesLog();
        $record['getRek2'] = $this->M_Rek2->findAll();
        $record['getDesa'] = $this->M_Desa->where('kd_kec', $this->getKdKec())->findAll();
        $record['ribbon'] = ribbon('Home');
        if ($record['log']['kd_level'] == 2) {
            $record['content'] = self::MODULE . '\desa';
        } else {
            $record['getAnggaranDesa'] = $this->S_Master->getAnggaranDesa();
            $record['getRealisasiDesa'] = $this->S_Kuitansi->getKuitansiDesa();
            $record['content'] = self::MODULE . '\index';
        }
        $this->render($record);
    }

    public final function setSessionTahun(): \CodeIgniter\HTTP\RedirectResponse
    {
        $tahun = $this->post('tahun');
        session()->push('is_logined', ['tahun' => $tahun]);
        return redirect()->back();
    }

}
