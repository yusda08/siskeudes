<?php

namespace Modules\Referensi\Services;

use Modules\Mapping\Models\Model_mapping_pegawai_desa;
use Modules\Referensi\Models\Model_desa;

class ReferensiService
{


    private Model_desa $M_Desa;
    private Model_mapping_pegawai_desa $M_MapPgwDesa;

    public function __construct()
    {
        $this->M_Desa = new Model_desa();
        $this->M_MapPgwDesa = new Model_mapping_pegawai_desa();
    }

    public final function getDesaLog(int $kd_kec): array
    {
        $log = aksesLog();
        $build = $this->M_Desa->where('kd_kec', $kd_kec);
        if ($log['kd_level'] == 2) {
            $build->where('kd_desa', $log['kd_desa']);
        } elseif ($log['kd_level'] == 3) {
            $mappings = $this->M_MapPgwDesa->where(['nip_nik' => $log['nip_nik']])->findAll();
            if ($mappings) {
                $kdDesa = array_column($mappings, 'kd_desa');
                $build->whereIn('kd_desa', $kdDesa);
            }
        }
        return $build->findAll();
    }
}