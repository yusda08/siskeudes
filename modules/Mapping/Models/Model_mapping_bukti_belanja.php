<?php

namespace Modules\Mapping\Models;

use CodeIgniter\Model;

class Model_mapping_bukti_belanja extends Model
{

    protected $table = 'mapping_bukti_belanja';
    protected $primaryKey = 'map_id';
    protected $allowedFields = ['id_bukti', 'kd_rincian', 'tahun', 'kd_kec', 'nama_bukti'];

    public final function getMapBelanja(array $whereArray = null): array
    {
        $build = $this->select($this->table . '.*, ref_rek_4.nama_objek')
            ->join('ref_rek_4', 'ref_rek_4.objek=mapping_bukti_belanja.kd_rincian')
            ->orderBy('kd_rincian');
        if ($whereArray) {
            $build->where($whereArray);
        }
        return $build->findAll();
    }

    public final function getMapBelanjaWhereIn(array $whereArray): array
    {
        return $this->select($this->table . '.*, ref_rek_4.nama_objek')
            ->join('ref_rek_4', 'ref_rek_4.objek=mapping_bukti_belanja.kd_rincian')
            ->orderBy('kd_rincian')
            ->where($whereArray)
            ->findAll();
    }

}
