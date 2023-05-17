<?php

namespace Modules\Input\Services;


use CodeIgniter\HTTP\Request;
use Modules\Input\Models\Model_data_bukti_belanja;
use Modules\Input\Models\Model_data_bukti_kuitansi;

class BuktiService
{

    private Model_data_bukti_kuitansi $M_Kuitansi;
    private Model_data_bukti_belanja $M_BktBelanja;

    public function __construct()
    {
        $this->M_Kuitansi = new Model_data_bukti_kuitansi();
        $this->M_BktBelanja = new Model_data_bukti_belanja();
    }

    /**
     * @throws \ReflectionException
     */
    public final function addBukti(Request $request): bool
    {
        $files = $request->getFileMultiple('bukti');
        $path = 'public/uploads/bukti';
        if (!file_exists(ROOTPATH . $path)) {
            mkdir(ROOTPATH . $path, 0777, true);
        }
        $status = false;
        foreach ($files as $i => $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $randomName = $img->getRandomName();
                $img->move(ROOTPATH . $path, $randomName);
                $data['id_bukti'] = $request->getPost('id_bukti')[$i];
                $data['no_bukti'] = $request->getPost('no_bukti');
                $data['kd_desa'] = $request->getPost('kd_desa');
                $data['kd_rincian'] = $request->getPost('kd_rincian');
                $data['file_name'] = $randomName;
                $data['file_path'] = $path;
                $data['tahun'] = aksesLog()['tahun'];
                $this->M_BktBelanja->insert($data);
                $status = true;
            }
        }
        return $status;

    }

    /**
     * @throws \Exception
     */
    public final function deleteBukti(Request $request): bool|\CodeIgniter\Database\BaseResult
    {
        $id = $request->getPost('id_bukti_belanja');
        $bukti = $this->M_BktBelanja->find($id);
        if (!$bukti) throw new \Exception('Bukti belanja tidak ada dalam database');
        unlink($bukti['file_path'] . '/' . $bukti['file_name']);
        return $this->M_BktBelanja->delete($id);
    }

    public final function postingBukti(Request $request): object|bool|int|string
    {
        $data = [
            'no_bukti' => $request->getPost('no_bukti'),
            'status_kuitansi' => $request->getPost('status_kuitansi'),
        ];
        return $this->M_Kuitansi->replace($data);
    }

    /**
     * @throws \ReflectionException
     */
    public final function validationBukti(Request $request): bool
    {
        $catatans = $request->getPost('catatan_validasi[]');
        $ids = $request->getPost('id_bukti_belanja[]');
        $status = false;
        foreach ($catatans as $i => $catatan) {
            $id = $ids[$i];
            $data['catatan_validasi'] = $catatan;
            $data['status_validasi'] = 1;
            $this->M_BktBelanja->update($id, $data);
            $status = true;
        }
        return $status;
    }

    /**
     * @throws \ReflectionException
     */
    public final function postingValidation(Request $request): object|bool|int|string
    {
        $no_bukti = $request->getPost('no_bukti');
        $data = [
            'status_validasi' => $request->getPost('status_validasi'),
        ];
        return $this->M_Kuitansi->set($data)->where('no_bukti', $no_bukti)->update();
    }

}