<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_setting
 *
 * @author Yusda Helmani
 */

namespace Modules\Referensi\Models;

use App\Models\MY_Model;

class Model_referensi extends MY_Model
{
	
	public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null)
	{
		parent::__construct($db, $validation);
		$this->ref_unit = $this->db->table("ref_unit");
		$this->ref_bidang = $this->db->table("ref_bidang_skpd");
		$this->uti_pendisposisi = $this->db->table("uti_pendisposisi");
	}
	

	function getRefBidang($kd_bidang = null)
	{
		$query = $this->ref_bidang;
		if (!empty($kd_bidang)) {
			$query->where(array('kd_bidang' => $kd_bidang));
		}
		return $query->get();
	}

	function getDataSkpd($arrayWhere = null)
	{
		$query = $this->db->table("data_skpd");
		if ($arrayWhere) {
			$query->where($arrayWhere);
		}
		return $query->get();
	}
	
	function getRefUnit()
	{
		$query = $this->ref_unit->get()->getRowArray();
		return $query;
	}
	
	function getDataPegawai($array = null)
	{
		$query = $this->db->table("data_pegawai")->select('*')->orderBy('kd_jabatan');
		if ($array) {
			$query->where($array);
		}
		return $query->get();
	}

	function getDataJabatan($array = null)
	{
		$query = $this->db->table("data_jabatan")->select('*')->orderBy('kd_peta');
		if ($array) {
			$query->where($array);
		}
		return $query->get();
	}

    function getDataBagian($array = null)
    {
        $query = $this->db->table("data_bagian")->select('*');
        if ($array) {
            $query->where($array);
        }
        return $query->get();
    }
	
	function getUtiPendisposisi($where = false)
	{
		$query = $this->uti_pendisposisi->join('data_pegawai AS b', 'uti_pendisposisi.kd_pegawai = b.kd_pegawai');
		if ($where != false) $query->where($where);
		return $query->get();
	}
	
	function getPegawaiNotExistUtiPendisposisi()
	{
		return $this->db->query("SELECT * FROM data_pegawai AS a
											WHERE NOT EXISTS (SELECT * FROM uti_pendisposisi AS b WHERE a.kd_pegawai = b.kd_pegawai)
											ORDER BY a.inisial")->getResultArray();
	}

}
