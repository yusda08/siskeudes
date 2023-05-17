<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use CodeIgniter\Controller;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Description of MyController
 *
 * @author Yusda Helmani
 */
class MyController extends Controller
{

    //put your code here

    function sessionAplikasi($kd_level, $kd_user)
    {
        $row = $this->M_Auth->join('user_level', 'kd_level')->find($kd_user);
        return array(
            'kd_user' => $kd_user,
            'kd_level' => $kd_level,
            'ket_level' => $row['ket_level'],
            'nama_user' => $row['nama_user'],
            'nip_nik' => $row['nip_nik'],
            'kd_desa' => $row['kd_desa'],
            'username' => $row['username'],
            'tahun' => date('Y'),
            'is_logined' => true
        );
    }

    public final function getTahun(int $tahun = null): mixed
    {
        return $this->log['tahun'] ? $this->log['tahun'] : date('Y');
    }

    public final function getKecamatan(): mixed
    {
        return $this->M_Kec->where('status_app', 1)->first();
    }

    public final function getKdKec(): string
    {
        $kec = $this->M_Kec->where('status_app', 1)->first();
        return $kec['kd_kec'];
    }

    public final function getKdDesa(): mixed
    {
        $log = aksesLog();
        return $log['kd_desa'] ?? $this->request->getGet('desa');
    }

    function getKode($kode)
    {
        $arr = explode('.', $kode);
        $kd_desa = $kode[0] . '.' . $kode[1];
        $kd_bid = $kd_desa . '.' . $kode[2];
        $kd_sub = $kd_bid . '.' . $kode[3];
        $kd_keg = $kd_sub . '.' . $kode[4];
        return $arr;
    }

    function generateQrCode($kode, $filename, $url)
    {
        $writer = new PngWriter();
        $qrCode = QrCode::create($url)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(500)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $logo = Logo::create(ROOTPATH . '/assets/img/logo_kab.png')
            ->setResizeToWidth(150)
            ->setResizeToHeight(150);
        $label = Label::create($kode)
            ->setTextColor(new Color(0, 0, 0));
        $result = $writer->write($qrCode, $logo, $label);
        header('Content-Type: ' . $result->getMimeType());
        return $result->saveToFile($filename);
    }

    function printQrCode($url)
    {
        $writer = new PngWriter();
        $qrCode = QrCode::create($url)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(500)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $logo = Logo::create(ROOTPATH . '/assets/img/logo_kab.png')
            ->setResizeToWidth(150)
            ->setResizeToHeight(150);
        $result = $writer->write($qrCode, $logo);
        header('Content-Type: ' . $result->getMimeType());
        return $result->getDataUri();
    }

}
