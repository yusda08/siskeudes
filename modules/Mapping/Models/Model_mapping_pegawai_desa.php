<?php

namespace Modules\Mapping\Models;

use CodeIgniter\Model;

class Model_mapping_pegawai_desa extends Model
{

    protected $table = 'mapping_pegawai_desa';
    protected $primaryKey = 'map_id';
    protected $allowedFields = ['kd_desa', 'nip_nik', 'tahun', 'nama_bukti'];

    public final function getMapPegawaiDesa(array $where = null): Model_mapping_pegawai_desa
    {
        $build = $this->join('ref_pegawai', 'nip_nik')->join('ref_desa', 'kd_desa');
        if ($where) {
            $build->where($where);
        }
        return $build;
    }

}
