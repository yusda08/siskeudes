<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Models as Model;
use Modules\Referensi\Models as M_Ref;

class BaseController extends MyController
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    //    protected $helpers = [];
    /**
     * Constructor.
     */

    public $log;
    public $db;
    public $validasi;

    function __construct()
    {
        helper(['mylib', 'asset', 'enkripsi', 'cookie', 'form', 'cms', 'text']);
        $this->log = aksesLog();
        $this->M_Auth = new Model\Model_Auth();
        $this->M_Kec = new M_Ref\Model_kecamatan();
        $this->db = db_connect();
        $this->validasi = \Config\Services::validation();
        $this->email = \Config\Services::email();
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session();
    }


    public function render(array $data)
    {
        $M_Menu = new \Modules\Setting\Models\Model_menu();
        $log = aksesLog();
        $data['validation'] = $this->validasi;
        $data['menu'] = $M_Menu->getMenuAkses($log['kd_level'])->getResultArray();
        echo view("backend/layout", $data);
    }

    public final function render_pdf(string $path, array $data = []): string
    {
        $data['template_pdf'] = 'backend/paper_pdf';
        return view($path, $data);
    }

    public function post($paramt)
    {
        return $this->request->getPost($paramt);
    }

    public function cekNotIsPOST($ket = 'Data Yang anda kirim Bukan method POST, Silahkan Hubungi administrator')
    {
        if ($this->request->getMethod() != "post") {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($ket);
        }
    }

    public function cekNotIsAjax($ket = 'Data Yang anda kirim Bukan method AJAX, Silahkan Hubungi administrator')
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($ket);
        }
    }

    public function getVar($paramt)
    {
        return $this->request->getVar($paramt);
    }

    public function get($paramt)
    {
        return $this->request->getGet($paramt);
    }

    public final function _get(string $paramt)
    {
        return $this->request->getGet($paramt) ? $this->request->getGet($paramt) : '';
    }

    public function file($paramt)
    {
        return $this->request->getFile($paramt);
    }

    public function fileMultiple($paramt)
    {
        return $this->request->getFileMultiple($paramt);
    }


    public final function flashdata(string $ket, bool $status = false): void
    {
        $alert = $status ? 'alert-primary' : 'alert-danger';
        session()->setFlashdata('tipe', $alert);
        session()->setFlashdata('msg', $ket);
    }

    public final function setJson(array $array): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->response->setJSON($array);
    }


//    public function flashdata($ket, $info)
//    {
//        if ($info == 'true' or $info == 'Berhasil' or $info == true) {
//            session()->setFlashdata('tipe', 'alert-info');
//            session()->setFlashdata('msg', 'Berhasil ' . $ket);
//        } elseif ($info == false or $info == 'false' or $info == 'Gagal') {
//            session()->setFlashdata('tipe', 'alert-danger');
//            session()->setFlashdata('msg', 'Gagal ' . $ket);
//        }
//    }

    public function insert_data($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function insert_duplicate($table, $data)
    {
        return $this->db->table($table)->on_duplicate($data);
    }

    public function update_data($nm_column, $id, $table, $data)
    {
        return $this->db->table($table)->where($nm_column, $id)->update($data);
    }

    public function update_where($column, $table, $data)
    {
        return $this->db->table($table)->where($column)->update($data);
    }

    public function delete_data($column, $id, $table)
    {
        return $this->db->table($table)->where($column, $id)->delete();
    }

    public function delete_where($column, $table)
    {
        return $this->db->table($table)->where($column)->delete();
    }

    function getGUID()
    {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 16);
        return $uuid;
    }


}