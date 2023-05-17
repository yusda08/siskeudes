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
use Modules\Surat_masuk\Controllers as C_Surat;
use Modules\Utility\Models\Model_utility;

class Disposisi extends BaseController
{

    var $module = 'Modules\Laporan\Views';
    var $moduleUrl = 'laporan/disposisi';

//put your code here
    public function __construct()
    {
        parent::__construct();
        $this->log = aksesLog();
        $this->M_Umum = new Surat_masuk\Model_umum();
        $this->C_Surat = new C_Surat\Data_surat();
        $this->M_Uti = new Model_utility();
    }

    function index()
    {
        $view = $this->module . '\disposisi\index';
        $record = $this->javasc_back();
        $record['tahun'] = $this->getTahun();
        $record['moduleUrl'] = $this->moduleUrl;
        $data = $this->layout_back($view, $record);
        $data['ribbon_left'] = ribbon_left('Laporan', 'Lembar Disposisi');
        $data['ribbon_right'] = ribbon_right($this->log['job']);
        echo $this->backend($data);
    }

    function cetakLembarDisposisi()
    {
        $view = $this->module . '\disposisi\lembar_disposisi';
        $record['tahun'] = $this->getTahun();
        $record['no_reg'] = $this->get('no_reg');
        $record['qr_code'] = $this->printQrCode(base_url($this->moduleUrl . '/cetak_lembar_disposisi?no_reg=' . $record['no_reg']));
//        $record['qr_code'] = '';
        $record['row_kop'] = $this->M_Uti->get_profilSkpd()->getRow();
        $record['getsifatSurat'] = $this->M_Uti->getsifatSurat()->getResultArray();
        $record['getListDisposisi'] = $this->M_Umum->getListDisposisi($record['tahun'], $record['no_reg'])->getResultArray();
        $record['row_srt'] = $this->M_Umum->getSuratUmum($record['tahun'], ['no_reg' => $record['no_reg']])->getRowArray();
        $record['getPenerimaSurat'] = json_decode($this->C_Surat->loadPenerimaUmum($record['no_reg']), true);
        $data['content'] = view($view, $record);
        $data['title'] = 'Lembar Disposisi';
        return $this->paper_print($data);
    }

    function cetakLembarDisposisiEmpty()
    {
        $view = $this->module . '\disposisi\lembar_disposisi_empty';
        $record['tahun'] = $this->getTahun();
        $record['no_reg'] = $this->get('no_reg');
        $record['qr_code'] = $this->printQrCode(base_url($this->moduleUrl . '/cetak_lembar_disposisi?no_reg=' . $record['no_reg']));
        $record['row_kop'] = $this->M_Uti->get_profilSkpd()->getRow();
        $record['getsifatSurat'] = $this->M_Uti->getsifatSurat()->getResultArray();
        $record['getListDisposisi'] = $this->M_Umum->getListDisposisi($record['tahun'], $record['no_reg'])->getResultArray();
        $record['row_srt'] = $this->M_Umum->getSuratUmum($record['tahun'], ['no_reg' => $record['no_reg']])->getRowArray();
        $data['content'] = view($view, $record);
        $data['title'] = 'Lembar Disposisi';
        return $this->paper_print($data);
    }

    function lembarDisposisiPdf()
    {
        $view = 'Modules\laporan\Views\disposisi\lembar_disposisi_pdf';
        $tahun = $this->get('tahun');
        $no_agenda = $this->get('agenda');
        $record['get_sifatSurat'] = $this->M_Uti->get_sifatSurat()->getResult();
        $record['row_kop'] = $this->M_Uti->get_profilSkpd()->getRow();
        $record['getPejabatan'] = $this->getPejabatan();
        if (!empty($tahun) and !empty($no_agenda)) {
            $row_srt = $this->M_Surmas->getSuratMasuk($tahun, $no_agenda)->getRow();
            $record['getDataPenerima'] = $this->M_Surmas->getDataPenerima($tahun, $no_agenda)->getResult();
            $record['disposisi'] = $this->M_Surmas->getDisposisi($tahun, $no_agenda)->getResult();
            $record['row_srt'] = $row_srt;
        }
        $pdfFilePath = "lembar_disposisi_" . $no_agenda . ".pdf";
        $data['titel'] = $pdfFilePath;
        $data['content'] = view($view, $record);
        $htmlMpdf = view('backend/paper', $data);
        $this->mpdf->SetHTMLFooter('<table width="100%" border="0" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
<td width="" style="border-right: 0px ;"><span style="font-weight: bold; font-style: italic;">Dicetak lewat ' . base_url() . '</span></td>
<td width="" style="border-right: 0px ;"><span style="font-weight: bold; font-style: italic;"> QR-CODE : ' . $row_srt->qr_code . ' </span></td>
<td width="10%" align="center" style="font-weight: bold; font-style: italic;border-right: 0px ;"></td>
<td width="20%" style="text-align: right;border-left: 0px ; ">Halaman {PAGENO} Dari {nbpg}</td>
</tr></table>');
        $this->mpdf->WriteHTML($htmlMpdf);
        header('Content-type: application/pdf');
        return redirect()->to($this->mpdf->Output($pdfFilePath, "I"));
    }



//    function lembarDisposisiPdf() {
//        $mpdf = new Mpdf(['mode' => 'utf-8']);
//        $mpdf->WriteHTML('Hello World');
//        return redirect()->to($mpdf->Output('filename.pdf', 'I'));
//    }

}
