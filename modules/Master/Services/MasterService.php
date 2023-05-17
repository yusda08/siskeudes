<?php

namespace Modules\Master\Services;


use Modules\Master\Models\Model_rab;
use Modules\Master\Models\Model_rab_rinci;

class MasterService
{

    private Model_rab $M_Rab;

    public function __construct()
    {
        $this->M_Rab = new Model_rab();
        $this->M_RabRinci = new Model_rab_rinci();
    }

    public final function getAnggaran(array $where = null)
    {
        $build = $this->M_Rab->select('SUBSTR(kd_rincian,1,4) kd_rincian, sum(anggaran) anggaran');
        if ($where) $build->where($where);
        return $build->groupBy('SUBSTR(kd_rincian,1,4)')->findAll();
    }


    public final function getAnggaranDesa(array $where = null)
    {
        $build = $this->M_Rab->select('kd_desa, sum(anggaran) anggaran');
        if ($where) $build->where($where);
        return $build->groupBy('kd_desa')->findAll();
    }

    public final function getRabRincianDesa($kd_desa)
    {
        $listRincian = $this->M_RabRinci->where('kd_desa', $kd_desa)->findAll();
        $anggaranADD = 0;
        $anggaranDDS = 0;
        $anggaranBHPRD = 0;
        $anggaranPBK = 0;
        $anggaranPAD = 0;
        $anggaranDLL = 0;
        foreach ($listRincian as $rinci) {
            if ($rinci['sumberdana'] == 'ADD') {
                $anggaranADD = $rinci['anggaran_stlh_pak'];
            } elseif ($rinci['sumberdana'] == 'DLL') {
                $anggaranDLL = $rinci['anggaran_stlh_pak'];
            } elseif ($rinci['sumberdana'] == 'DDS') {
                $anggaranDDS = $rinci['anggaran_stlh_pak'];
            } elseif ($rinci['sumberdana'] == 'PBH') {
                $anggaranPBK = $rinci['anggaran_stlh_pak'];
            }
        }
    }
}