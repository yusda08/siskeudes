<?php

namespace Modules\Report\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\Model_bidang;
use Modules\Master\Models\Model_kegiatan;
use Modules\Master\Models\Model_rab;
use Modules\Master\Models\Model_spp;
use Modules\Master\Models\Model_subbidang;
use Modules\Master\Services\KuitansiService;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Services\ReferensiService;
use Mpdf\Mpdf;


class BuktiBelanja extends BaseController
{

    const MODULE = 'Modules\Report\Views\bukti_belanja';
    private Model_desa $M_Desa;

    private const CONSTRUCT_PDF = [
        'mode' => 'utf-8',
        'format' => 'Legal-L',
        'default_font_size' => 1,
        'default_font' => 'Tahoma',
        'margin_left' => 8,
        'margin_right' => 35,
        'margin_top' => 8,
        'margin_bottom' => 8,
        'margin_header' => 8,
        'margin_footer' => 8
    ];
    private Mpdf $Mpdf;
    private Model_spp $M_Spp;
    private ReferensiService $S_Referensi;

    public function __construct()
    {
        parent::__construct();
        $this->M_Desa = new Model_desa();
        $this->S_Referensi = new ReferensiService();
        $this->M_Spp = new Model_spp();
        $this->Mpdf = new Mpdf(static::CONSTRUCT_PDF);
    }


    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDesa'] = $this->S_Referensi->getDesaLog($this->getKdKec());
        if ($record['kd_desa']) {
            $record['desa'] = $this->M_Desa->where(['kd_desa' => $record['kd_desa']])->first();
            $record['getSpp'] = $this->M_Spp->where(['kd_desa' => $record['kd_desa']])->findAll();
        }
        $record['ribbon'] = ribbon('Laporan', 'Bukti Belanja');
        $this->render($record);
    }


    /**
     * @throws \Mpdf\MpdfException
     */
    public final function pdf()
    {
        $record['kd_desa'] = $this->getKdDesa();
        $record['desa'] = $this->M_Desa->where(['kd_desa' => $record['kd_desa']])->first();
        $record['getSpp'] = $this->M_Spp->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['title'] = "anggaran_belanja.pdf";
        $htmlMpdf = $this->render_pdf(self::MODULE . '\pdf', $record);
        $this->Mpdf->WriteHTML($htmlMpdf);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->Mpdf->Output($record['title'], 'I');
    }

}
