<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseLib;
use Modules\Master\Services\KuitansiService;

class Kuitansi extends BaseController
{
    private KuitansiService $S_Kuitansi;

    public function __construct()
    {
        parent::__construct();
        $this->S_Kuitansi = new KuitansiService();
    }

    public final function loadRealisasi()
    {
        try {
            $log = aksesLog();
            $array = $log['kd_desa'] ? ['kd_desa' => $log['kd_desa']] : [];
            $getDataSpp = $this->S_Kuitansi->getKuitansiSppBukti($array);
            $getDataSpj = $this->S_Kuitansi->getKuitansiSpjBukti($array);
            $data = [];
            foreach ($getDataSpp as $i => $dataSpp) {
                if ($dataSpp['kd_rincian'] != null) {
                    $anggaranSpj = 0;
                    foreach ($getDataSpj as $i => $dataSpj) {
                        if ($dataSpp['kd_rincian'] == $dataSpj['kd_rincian']) {
                            $anggaranSpj = (int)$dataSpj['realisasi'];
                            break;
                        }
                    }
                    $dd['kd_rincian'] = $dataSpp['kd_rincian'];
                    $dd['realisasi'] = (int)$dataSpp['realisasi'] + $anggaranSpj;
                    $data[] = $dd;
                }
            }
            $response = ResponseLib::getStatusTrue(data: $data);
        } catch (\Exception $exception) {
            $response = ResponseLib::getStatusFalse($exception->getMessage());
        }
        return $this->setJson($response);
    }

}
