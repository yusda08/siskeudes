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
use Modules\Surat\Models\Model_notadinas;
use Modules\Surat\Models\Model_surat_keluar;
use Modules\Utility\Models\Model_utility;
use \Mpdf\Mpdf;

class Lap_surat_keluar extends BaseController {

    var $M_Surmas;
    var $M_Uti;
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
    public function __construct() {
        parent::__construct();
        $this->log = aksesLog();
        $this->M_Surmas = new Model_notadinas();
        $this->M_Surkel = new Model_surat_keluar();
        $this->M_Uti = new Model_utility();
        $this->mpdf = new Mpdf($this->constructor);
    }

    function index() {
        $view = 'Modules\laporan\Views\surat_keluar\index';
        $tahun = isset($_REQUEST['tahun']) ? $this->get('tahun') : date('Y');
        $record = $this->javasc_back();
        $record['tahun'] = $tahun;
        $record['kd_bidang'] = $this->getKdBidang();
        $record['getRefBidang'] = $this->getBidang($this->log['kd_level']);
        $data = $this->layout_back($view, $record);
        $data['ribbon_left'] = ribbon_left('Laporan', 'Disposisi');
        $data['ribbon_right'] = ribbon_right($this->log['job']);
        echo $this->backend($data);
    }

    function suratKeluarPdf() {
        $tahun = $this->get('tahun');
        $kd_surat = $this->get('agenda');
        $row_srt = $this->M_Surkel->getSuratKeluar($tahun, $kd_surat)->getRow();
        $folder = 'surat_keluar';
        $folder_bln = date('m', strtotime($row_srt->tgl_surat));
        $nama_file = $row_srt->nama_file;
        if ($row_srt->status_signature == 1) {
            $folder = 'signature';
            $folder_bln = date('m', strtotime($row_srt->tgl_signature));
            $nama_file = $row_srt->nama_file_ttd;
        }
        return redirect()->to(base_url('public/uploads/' . $folder . '/' . $tahun . '/' . $folder_bln . '/' . $nama_file));
    }

    function loadSuratKeluar() {
        $this->cekNotIsAjax();
        $this->cekNotIsPOST();
        $tahun = $this->post('tahun');
        $kd_bidang = $this->post('kd_bidang');
        $getSuratKeluar = $this->M_Surkel->getSuratKeluarTtd($tahun, $kd_bidang)->getResult();
//        return json_encode($getSuratKeluar);
        $data = array();
        $no = 1;
        foreach ($getSuratKeluar as $row) {
            $print_pdf = '<span class="badge badge-danger badge-pill">Proses </span>';
            if ($row->status_arsip == 'Y') {
                $print_pdf = '<a class="btn btn-warning btn-flat" target="_blank"
                    href="' . site_url("laporan/surat_keluar/surat_keluar_pdf?tahun=$tahun&agenda=$row->kd_surat") . '">
                    <i class="fas fa-print"></i> Print PDF</a>';
            }
            $arr = array();
            $arr[] = sprintfNumber($row->kd_surat);
            $arr[] = $row->no_surat;
            $arr[] = $row->perihal;
            $arr[] = \Tgl_indo::indo($row->tgl_surat);
            $arr[] = $row->tujuan;
            $arr[] = $row->jenis_surat;
            $arr[] = $print_pdf;
            $data[] = $arr;
        }
//        return json_encode($data);

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => count_allTable('surat_keluar', array('tahun' => $tahun, 'kd_bidang' => $kd_bidang)),
            "recordsFiltered" => $this->M_Surkel->count_filtered($tahun, $kd_bidang),
            "data" => $data,
        );
        echo json_encode($output);
    }

}
