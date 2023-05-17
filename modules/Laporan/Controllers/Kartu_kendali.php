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

namespace Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use Modules\Surat_masuk\Models as Surat_masuk;
use Modules\Utility\Models\Model_utility;

//use Mpdf\Mpdf;

class Kartu_kendali extends BaseController
{

    var $module = 'Modules\Laporan\Views';
    var $moduleUrl = 'laporan/kartu_kendali';

    private $constructor = [
        'mode' => 'utf-8',
        'format' => 'Legal-P',
        'default_font_size' => 1,
        'default_font' => 'Tahoma',
        'margin_left' => 8,
        'margin_right' => 8,
        'margin_top' => 8,
        'margin_bottom' => 35,
        'margin_header' => 8,
        'margin_footer' => 35
    ];

//put your code here
    public function __construct()
    {
        parent::__construct();
        $this->log = aksesLog();
        $this->M_Uti = new Model_utility();
        $this->M_Nd = new Surat_masuk\Model_notadinas();
//        $this->mpdf = new Mpdf($this->constructor);
    }

    function index()
    {
        $view = $this->module . '\kartu_kendali\index';
        $record = $this->javasc_back();

        $data = $this->layout_back($view, $record);
        $data['ribbon_left'] = ribbon_left('Laporan', 'Kartu Kendali');
        $data['ribbon_right'] = ribbon_right($this->log['job']);
        echo $this->backend($data);
    }

    function cetakKartuKendali()
    {
        $view = $this->module . '\kartu_kendali\view_kartu_kendali';
        $record = $this->javasc_back();
        $record['moduleUrl'] = $this->moduleUrl;
        $record['tahun'] = $this->log['tahun'];
        $record['no_reg'] = $this->get('no_reg');
        $record['qr_code'] = $this->printQrCode(base_url($this->moduleUrl . '/cetak_kartu_kendali?no_reg=' . $record['no_reg']));
//        $record['qr_code'] = '';
        $record['row_kop'] = $this->M_Uti->get_profilSkpd()->getRow();
        $record['getListDisposisiNd'] = $this->M_Nd->getListDisposisiNd($record['tahun'], $record['no_reg'])->getResultArray();
        $record['row_nd'] = $this->M_Nd->getNotaDinas($record['tahun'], ['no_reg' => $record['no_reg']])->getRowArray();
        $data['content'] = view($view, $record);
        $data['title'] = 'Kartu Kendali';
        return $this->paper_print($data);
    }

    function cetakKartuKendaliEmpty()
    {
        $view = $this->module . '\kartu_kendali\view_kartu_kendali_empty';
        $record = $this->javasc_back();
        $record['moduleUrl'] = $this->moduleUrl;
        $record['tahun'] = $this->log['tahun'];
        $record['no_reg'] = $this->get('no_reg');
        $record['qr_code'] = $this->printQrCode(base_url($this->moduleUrl . '/cetak_kartu_kendali?no_reg=' . $record['no_reg']));
        $record['row_kop'] = $this->M_Uti->get_profilSkpd()->getRow();
        $record['getListDisposisiNd'] = $this->M_Nd->getListDisposisiNd($record['tahun'], $record['no_reg'])->getResultArray();
        $record['row_nd'] = $this->M_Nd->getNotaDinas($record['tahun'], ['no_reg' => $record['no_reg']])->getRowArray();
        $data['content'] = view($view, $record);
        $data['title'] = 'Kartu Kendali';
        return $this->paper_print($data);
    }

}
