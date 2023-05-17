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

namespace Modules\Integrasi\Models;

use CodeIgniter\Model;

class M_Tarik extends Model
{
    public function saveRekening(array $dataRekening)
    {
        $this->db->transBegin();
        foreach ($dataRekening as $rek1) {
            $dRek1['akun'] = $rek1['Akun'];
            $dRek1['nama_akun'] = $rek1['Nama_Akun'];
            $dRek1['no_lap'] = $rek1['NoLap'];
            $this->db->table('ref_rek_1')->on_duplicate($dRek1);
            foreach ($rek1['rek_2'] as $rek2) {
                $dRek2['akun'] = $rek2['Akun'];
                $dRek2['kelompok'] = $rek2['Kelompok'];
                $dRek2['nama_kelompok'] = $rek2['Nama_Kelompok'];
                $this->db->table('ref_rek_2')->on_duplicate($dRek2);
                foreach ($rek2['rek_3'] as $rek3) {
                    $dRek3['jenis'] = $rek3['Jenis'];
                    $dRek3['kelompok'] = $rek3['Kelompok'];
                    $dRek3['nama_jenis'] = $rek3['Nama_Jenis'];
                    $dRek3['formula'] = $rek3['Formula'];
                    $this->db->table('ref_rek_3')->on_duplicate($dRek3);
                    foreach ($rek3['rek_4'] as $rek4) {
                        $dRek4['jenis'] = $rek4['Jenis'];
                        $dRek4['objek'] = $rek4['Obyek'];
                        $dRek4['nama_objek'] = $rek4['Nama_Obyek'];
                        $dRek4['peraturan'] = $rek4['Peraturan'];
                        $this->db->table('ref_rek_4')->on_duplicate($dRek4);
                    }
                }
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }

    public function saveLokasi(array $dataLokasi)
    {
        $this->db->transBegin();
        foreach ($dataLokasi as $kec) {
            $ddKec['kd_kec'] = $kec['Kd_Kec'];
            $ddKec['nama_kecamatan'] = $kec['Nama_Kecamatan'];
            $this->db->table('ref_kecamatan')->replace($ddKec);
            foreach ($kec['desa'] as $desa) {
                $ddDesa['kd_desa'] = $desa['Kd_Desa'];
                $ddDesa['kd_kec'] = $desa['Kd_Kec'];
                $ddDesa['nama_desa'] = $desa['Nama_Desa'];
                $this->db->table('ref_desa')->replace($ddDesa);
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }

    public function savePerencanaanBidang(array $dataRab)
    {
        $this->db->transBegin();
        foreach ($dataRab as $bid) {
            $dBid['tahun'] = $bid['Tahun'];
            $dBid['kd_desa'] = $bid['Kd_Desa'];
            $dBid['kd_bid'] = $bid['Kd_Bid'];
            $dBid['nama_bidang'] = $bid['Nama_Bidang'];
            $this->db->table('ta_bidang')->replace($dBid);
            foreach ($bid['sub_bidang'] as $subbid) {
                $dSubBid['tahun'] = $bid['Tahun'];
                $dSubBid['kd_desa'] = $bid['Kd_Desa'];
                $dSubBid['kd_bid'] = $bid['Kd_Bid'];
                $dSubBid['kd_sub'] = $subbid['Kd_Sub'];
                $dSubBid['nama_subbidang'] = $subbid['Nama_SubBidang'];
                $this->db->table('ta_subbidang')->replace($dSubBid);
                foreach ($subbid['kegiatan'] as $keg) {
                    $dkeg['tahun'] = $bid['Tahun'];
                    $dkeg['kd_desa'] = $bid['Kd_Desa'];
                    $dkeg['kd_bid'] = $bid['Kd_Bid'];
                    $dkeg['kd_sub'] = $subbid['Kd_Sub'];
                    $dkeg['kd_keg'] = $keg['Kd_Keg'];
                    $dkeg['id_keg'] = $keg['ID_Keg'];
                    $dkeg['nama_kegiatan'] = $keg['Nama_Kegiatan'];
                    $dkeg['pagu'] = $keg['Pagu'];
                    $dkeg['pagu_pak'] = $keg['Pagu_PAK'];
                    $dkeg['nm_pptkd'] = $keg['Nm_PPTKD'];
                    $dkeg['nip_pptkd'] = $keg['NIP_PPTKD'];
                    $dkeg['jbtn_pptkd'] = $keg['Jbt_PPTKD'];
                    $dkeg['lokasi'] = $keg['Lokasi'];
                    $dkeg['waktu'] = $keg['Waktu'];
                    $dkeg['keluaran'] = $keg['Keluaran'];
                    $dkeg['sumberdana'] = $keg['Sumberdana'];
                    $dkeg['nilai'] = $keg['Nilai'];
                    $dkeg['nilai_pak'] = $keg['NilaiPAK'];
                    $dkeg['satuan'] = $keg['Satuan'];
                    $this->db->table('ta_kegiatan')->replace($dkeg);
                }
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }

    function saveRab(array $getData)
    {
        $this->db->transBegin();
        foreach ($getData as $rab) {
            $dRab['tahun'] = $rab['Tahun'];
            $dRab['kd_desa'] = $rab['Kd_Desa'];
            $dRab['kd_keg'] = $rab['Kd_Keg'];
            $dRab['kd_rincian'] = $rab['Kd_Rincian'];
            $dRab['kd_subrinci'] = $rab['Kd_SubRinci'];
            $dRab['anggaran'] = $rab['Anggaran'];
            $dRab['anggaran_pak'] = $rab['AnggaranPAK'];
            $dRab['anggaran_stlh_pak'] = $rab['AnggaranStlhPAK'];
            $dRab['nama_objek'] = $rab['Nama_Obyek'];
            $this->db->table('ta_rab')->replace($dRab);
            foreach ($rab['rincian'] as $rab_rinc) {
                $dRabRinc['tahun'] = $rab_rinc['Tahun'];
                $dRabRinc['kd_desa'] = $rab_rinc['Kd_Desa'];
                $dRabRinc['kd_keg'] = $rab_rinc['Kd_Keg'];
                $dRabRinc['kd_rincian'] = $rab_rinc['Kd_Rincian'];
                $dRabRinc['kd_subrinci'] = $rab_rinc['Kd_SubRinci'];
                $dRabRinc['no_urut'] = $rab_rinc['No_Urut'];
                $dRabRinc['sumberdana'] = $rab_rinc['SumberDana'];
                $dRabRinc['uraian'] = $rab_rinc['Uraian'];
                $dRabRinc['satuan'] = $rab_rinc['Satuan'];
                $dRabRinc['jml_satuan'] = $rab_rinc['JmlSatuan'];
                $dRabRinc['hrg_satuan'] = $rab_rinc['HrgSatuan'];
                $dRabRinc['anggaran'] = $rab_rinc['Anggaran'];
                $dRabRinc['jml_satuan_pak'] = $rab_rinc['JmlSatuanPAK'];
                $dRabRinc['hrg_satuan_pak'] = $rab_rinc['HrgSatuanPAK'];
                $dRabRinc['anggaran_stlh_pak'] = $rab_rinc['AnggaranStlhPAK'];
                $dRabRinc['anggaran_pak'] = $rab_rinc['AnggaranPAK'];
                $dRabRinc['kode_sbu'] = $rab_rinc['Kode_SBU'];
                $this->db->table('ta_rab_rinci')->replace($dRabRinc);
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }

    function saveSpp(array $getData)
    {
        $this->db->transBegin();
        foreach ($getData as $spp) {
            $dSpp['tahun'] = $spp['Tahun'];
            $dSpp['kd_desa'] = $spp['Kd_Desa'];
            $dSpp['no_spp'] = $spp['No_SPP'];
            $dSpp['tgl_spp'] = $spp['Tgl_SPP'];
            $dSpp['jn_spp'] = $spp['Jn_SPP'];
            $dSpp['keterangan'] = $spp['Keterangan'];
            $dSpp['jumlah'] = $spp['Jumlah'];
            $dSpp['potongan'] = $spp['Potongan'];
            $dSpp['status'] = $spp['Status'];
            $this->db->table('ta_spp')->replace($dSpp);
            foreach ($spp['bukti'] as $spp_bukti) {
                $dSppBuk['tahun'] = $spp_bukti['Tahun'];
                $dSppBuk['kd_desa'] = $spp_bukti['Kd_Desa'];
                $dSppBuk['no_bukti'] = $spp_bukti['No_Bukti'];
                $dSppBuk['no_spp'] = $spp_bukti['No_SPP'];
                $dSppBuk['kd_keg'] = $spp_bukti['Kd_Keg'];
                $dSppBuk['tgl_bukti'] = $spp_bukti['Tgl_Bukti'];
                $dSppBuk['kd_rincian'] = $spp_bukti['Kd_Rincian'];
                $dSppBuk['kd_subrinci'] = $spp_bukti['Kd_SubRinci'];
                $dSppBuk['sumberdana'] = $spp_bukti['Sumberdana'];
                $dSppBuk['nm_penerima'] = $spp_bukti['Nm_Penerima'];
                $dSppBuk['alamat'] = $spp_bukti['Alamat'];
                $dSppBuk['rek_bank'] = $spp_bukti['Rek_Bank'];
                $dSppBuk['nm_bank'] = $spp_bukti['Nm_Bank'];
                $dSppBuk['npwp'] = $spp_bukti['NPWP'];
                $dSppBuk['keterangan'] = $spp_bukti['Keterangan'];
                $dSppBuk['nilai'] = $spp_bukti['Nilai'];
                $this->db->table('ta_spp_bukti')->replace($dSppBuk);
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }

    function saveSpj(array $getData)
    {
        $this->db->transBegin();
        foreach ($getData as $spj) {
            $dSpj['tahun'] = $spj['Tahun'];
            $dSpj['kd_desa'] = $spj['Kd_Desa'];
            $dSpj['no_spp'] = $spj['No_SPP'];
            $dSpj['no_spj'] = $spj['No_SPJ'];
            $dSpj['tgl_spj'] = $spj['Tgl_SPJ'];
            $dSpj['keterangan'] = $spj['Keterangan'];
            $dSpj['jumlah'] = $spj['Jumlah'];
            $dSpj['potongan'] = $spj['Potongan'];
            $dSpj['status'] = $spj['Status'];
            $dSpj['kunci'] = $spj['Kunci'];
            $this->db->table('ta_spj')->replace($dSpj);
            foreach ($spj['bukti'] as $spj_bukti) {
                $dSpjBuk['tahun'] = $spj_bukti['Tahun'];
                $dSpjBuk['no_spj'] = $spj_bukti['No_SPJ'];
                $dSpjBuk['kd_keg'] = $spj_bukti['Kd_Keg'];
                $dSpjBuk['kd_rincian'] = $spj_bukti['Kd_Rincian'];
                $dSpjBuk['kd_subrinci'] = $spj_bukti['Kd_SubRinci'];
                $dSpjBuk['no_bukti'] = $spj_bukti['No_Bukti'];
                $dSpjBuk['tgl_bukti'] = $spj_bukti['Tgl_Bukti'];
                $dSpjBuk['sumberdana'] = $spj_bukti['Sumberdana'];
                $dSpjBuk['kd_desa'] = $spj_bukti['Kd_Desa'];
                $dSpjBuk['nm_penerima'] = $spj_bukti['Nm_Penerima'];
                $dSpjBuk['alamat'] = $spj_bukti['Alamat'];
                $dSpjBuk['rek_bank'] = $spj_bukti['Rek_Bank'];
                $dSpjBuk['nm_bank'] = $spj_bukti['Nm_Bank'];
                $dSpjBuk['npwp'] = $spj_bukti['NPWP'];
                $dSpjBuk['keterangan'] = $spj_bukti['Keterangan'];
                $dSpjBuk['nilai'] = $spj_bukti['Nilai'];
                $this->db->table('ta_spj_bukti')->replace($dSpjBuk);
            }
        }

        if ($this->db->transStatus() === FALSE) {
            return $this->db->transRollback();
        } else {
            return $this->db->transCommit();
        }
    }
}
