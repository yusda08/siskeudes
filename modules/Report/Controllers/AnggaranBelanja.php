<?php

namespace Modules\Report\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\Model_bidang;
use Modules\Master\Models\Model_kegiatan;
use Modules\Master\Models\Model_rab;
use Modules\Master\Models\Model_subbidang;
use Modules\Master\Services\KuitansiService;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Services\ReferensiService;
use Mpdf\Mpdf;


class AnggaranBelanja extends BaseController
{

    const MODULE = 'Modules\Report\Views\anggaran_belanja';
    private Model_desa $M_Desa;
    private Model_bidang $M_Bidang;
    private Model_subbidang $M_SubBidang;
    private Model_kegiatan $M_Kegiatan;
    private Model_rab $M_Rab;
    private KuitansiService $S_Kuitansi;

    private const CONSTRUCT_PDF = [
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
    private Mpdf $Mpdf;
    private ReferensiService $S_Referensi;

    public function __construct()
    {
        parent::__construct();
        $this->M_Desa = new Model_desa();
        $this->S_Referensi = new ReferensiService();
        $this->M_Bidang = new Model_bidang();
        $this->M_SubBidang = new Model_subbidang();
        $this->M_Kegiatan = new Model_kegiatan();
        $this->M_Rab = new Model_rab();
        $this->S_Kuitansi = new KuitansiService();
        $this->Mpdf = new Mpdf(static::CONSTRUCT_PDF);
    }


    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDesa'] = $this->S_Referensi->getDesaLog($this->getKdKec());
        if ($record['kd_desa']) {
            $record['desa'] = $this->M_Desa->where(['kd_kec' => $this->getKdKec(), 'kd_desa' => $record['kd_desa']])->first();
            $record['getBidang'] = $this->M_Bidang->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getSubBidang'] = $this->M_SubBidang->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getKegiatan'] = $this->M_Kegiatan->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getRab'] = $this->M_Rab->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getKuitansiAll'] = $this->S_Kuitansi->getKuitansiAll(['kd_desa' => $record['kd_desa']]);

        }
        $record['ribbon'] = ribbon('Laporan', 'Anggaran Belanja');
        $this->render($record);
    }

    public final function excel(): void
    {
        $record['kd_desa'] = $this->getKdDesa();
        $record['desa'] = $this->M_Desa->where(['kd_kec' => $this->getKdKec(), 'kd_desa' => $record['kd_desa']])->first();
        $record['getBidang'] = $this->M_Bidang->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getSubBidang'] = $this->M_SubBidang->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getKegiatan'] = $this->M_Kegiatan->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getRab'] = $this->M_Rab->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getKuitansiAll'] = $this->S_Kuitansi->getKuitansiAll(['kd_desa' => $record['kd_desa']]);
        echo view(self::MODULE . '\excel', $record);
    }


    public final function pdf()
    {

        $data['title'] = "anggaran_belanja.pdf";
        $htmlMpdf = $this->render_pdf(self::MODULE . '\pdf', $data);
        $this->Mpdf->WriteHTML($htmlMpdf);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->Mpdf->Output($data['title'], 'I');
    }

}
