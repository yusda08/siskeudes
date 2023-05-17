<?php

namespace Modules\Master\Services;


use Modules\Master\Models\Model_spj_bukti;
use Modules\Master\Models\Model_spp_bukti;

class KuitansiService
{

    private Model_spp_bukti $M_SppBkt;
    private Model_spj_bukti $M_SpjBkt;

    public function __construct()
    {
        $this->M_SppBkt = new Model_spp_bukti();
        $this->M_SpjBkt = new Model_spj_bukti();
    }

    public final function getKuitansiSppFindAll(string $jenis, array $params = null): array
    {
        $build = $jenis == 'UM'
            ? $this->M_SpjBkt->where($params)
                ->join('ta_spj', 'no_spj')
            : $this->M_SppBkt->where($params);
        return $build->join('data_bukti_kuitansi', 'no_bukti', 'left')->findAll();
    }

    public final function getKuitansiSppFirst(string $jenis, array $params = null): array
    {
        $build = $jenis == 'UM'
            ? $this->M_SpjBkt->where($params)->join('ta_spj', 'no_spj')
            : $this->M_SppBkt->where($params);

        return $build->join('data_bukti_kuitansi', 'no_bukti', 'left')->first();
    }

    public final function getKuitansiSppBukti(array $where = null): array
    {
        $build = $this->M_SppBkt->select('SUBSTR(kd_rincian,1,4) kd_rincian, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('SUBSTR(kd_rincian,1,4)')->findAll();
    }

    public final function getKuitansiSpjBukti(array $where = null): array
    {
        $build = $this->M_SpjBkt->select('SUBSTR(kd_rincian,1,4) kd_rincian, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('SUBSTR(kd_rincian,1,4)')->findAll();
    }

    public final function getKuitansiSppBuktiAll(array $where = null): array
    {
        $build = $this->M_SppBkt->select('no_bukti, kd_keg, kd_rincian, kd_subrinci, keterangan, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('no_bukti, kd_keg, kd_rincian, kd_subrinci')->findAll();
    }

    public final function getKuitansiSpjBuktiAll(array $where = null): array
    {
        $build = $this->M_SpjBkt->select('no_bukti, kd_keg, kd_rincian, kd_subrinci, keterangan, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('no_bukti, kd_keg, kd_rincian, kd_subrinci')->findAll();
    }


    public final function getKuitansiSppBuktiDesa(array $where = null): array
    {
        $build = $this->M_SppBkt->select('kd_desa, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('kd_desa')->findAll();
    }

    public final function getKuitansiSpjBuktiDesa(array $where = null): array
    {
        $build = $this->M_SpjBkt->select('kd_desa, sum(nilai) realisasi');
        if ($where) $build->where($where);
        return $build->groupBy('kd_desa')->findAll();
    }

    public final function getKuitansiDesa(array $where = null): array
    {
        $spjDesa = $this->getKuitansiSpjBuktiDesa($where);
        $sppDesa = $this->getKuitansiSppBuktiDesa($where);
//        foreach ($sppDesa as $i => $spp) {
//            $reaSpj = 0;
//            foreach ($spjDesa as $spj) {
//                if ($spp['kd_desa'] === $spj['kd_desa']) {
//                    $reaSpj = $spj['realisasi'];
//                    break;
//                }
//            }
//            $sppDesa[$i]['realisasi'] = (int)$spp['realisasi'] + $reaSpj;
//        }

        return array_merge($sppDesa, $spjDesa);
    }

    public final function getKuitansiAll(array $where = null): array
    {
        $spjDesa = $this->getKuitansiSpjBuktiAll($where);
        $sppDesa = $this->getKuitansiSppBuktiAll($where);
        //        foreach ($sppDesa as $i => $spp) {
//            $reaSpj = 0;
//            $keterangan = '';
//            $no_bukti = '';
//            foreach ($spjDesa as $spj) {
//                if ($spp['kd_keg'] === $spj['kd_keg']
//                    and $spp['kd_rincian'] === $spj['kd_rincian']
//                    and $spp['kd_subrinci'] === $spj['kd_subrinci']) {
//                    $reaSpj = $spj['realisasi'];
//                    $keterangan = $spj['keterangan'];
//                    $no_bukti = $spj['no_bukti'];
//                    break;
//                }
//            }
//            $sppDesa[$i]['realisasi'] = (int)$spp['realisasi'];
//            $sppDesa[$i]['keterangan'] = $keterangan ?: $spp['keterangan'];
//            $sppDesa[$i]['no_bukti'] = $no_bukti ?: $spp['no_bukti'];
//        }
        return array_merge($sppDesa, $spjDesa);
    }


}