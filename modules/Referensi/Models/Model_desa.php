<?php
namespace Modules\Referensi\Models;


use CodeIgniter\Model;

class Model_desa extends Model
{
    protected $table = 'ref_desa';
    protected $primaryKey = 'id_desa';
    protected $allowedFields = ['kd_kec', 'kd_desa', 'nama_desa'];


//    function getDesa($arrayWhere = null){
//         $builder = $this->db->table('ref_desa')->select('*');
//        if($arrayWhere){
//            $builder->where($arrayWhere);
//        }
//        return $builder->get();
//    }
}
