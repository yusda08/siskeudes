<?php

namespace Modules\Report\Controllers;

use App\Controllers\BaseController;
use Modules\Master\Models\Model_bidang;
use Modules\Master\Models\Model_kegiatan;
use Modules\Master\Models\Model_rab;
use Modules\Master\Models\Model_rab_rinci;
use Modules\Master\Models\Model_spp;
use Modules\Master\Models\Model_subbidang;
use Modules\Master\Services\KuitansiService;
use Modules\Referensi\Models\Model_desa;
use Modules\Referensi\Services\ReferensiService;
use Mpdf\Mpdf;


class RealisasiKegiatan extends BaseController
{

    const MODULE = 'Modules\Report\Views\realisasi_kegiatan';
    const GET_BIDANG = 'getBidang';
    private Model_desa $M_Desa;

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
    private Model_bidang $M_Bidang;
    private Model_kegiatan $M_Kegiatan;
    private KuitansiService $S_Kuitansi;
    private Model_rab $M_Rab;
    private Model_rab_rinci $M_RabRinci;
    private Model_subbidang $M_SubBidang;

    public function __construct()
    {
        parent::__construct();
        $this->M_Desa = new Model_desa();
        $this->S_Referensi = new ReferensiService();
        $this->M_Bidang = new Model_bidang();
        $this->M_SubBidang = new Model_subbidang();
        $this->M_Kegiatan = new Model_kegiatan();
        $this->M_Rab = new Model_rab();
        $this->M_RabRinci = new Model_rab_rinci();
        $this->S_Kuitansi = new KuitansiService();
        $this->Mpdf = new Mpdf(static::CONSTRUCT_PDF);
    }


    public final function index(): void
    {
        $record['content'] = self::MODULE . '\index';
        $record['kd_desa'] = $this->getKdDesa();
        $record['getDesa'] = $this->S_Referensi->getDesaLog($this->getKdKec());
        if ($record['kd_desa']) {
            $record['desa'] = $this->M_Desa->where(['kd_desa' => $record['kd_desa']])->first();
            $record['getBidang'] = $this->M_Bidang->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getSubBidang'] = $this->M_SubBidang->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getKegiatan'] = $this->M_Kegiatan->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getRab'] = $this->M_Rab->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getRabRinc'] = $this->M_RabRinci->where(['kd_desa' => $record['kd_desa']])->findAll();
            $record['getRealisasi'] = $this->S_Kuitansi->getKuitansiAll(['kd_desa' => $record['kd_desa']]);
        }
        $record['ribbon'] = ribbon('Laporan', 'Realisasi Kegiatan');
        $this->render($record);
    }


    public final function excel(): void
    {
        $record['kd_desa'] = $this->getKdDesa();
        $record['desa'] = $this->M_Desa->where(['kd_desa' => $record['kd_desa']])->first();
        $record['getBidang'] = $this->M_Bidang->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getKegiatan'] = $this->M_Kegiatan->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getRab'] = $this->M_Rab->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getRabRinc'] = $this->M_RabRinci->where(['kd_desa' => $record['kd_desa']])->findAll();
        $record['getRealisasi'] = $this->S_Kuitansi->getKuitansiAll(['kd_desa' => $record['kd_desa']]);
        echo view(self::MODULE . '\excel', $record);
    }

}
