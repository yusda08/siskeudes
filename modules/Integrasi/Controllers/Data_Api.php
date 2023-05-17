<?php

namespace Modules\Integrasi\Controllers;

use App\Controllers\BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


class Data_Api extends BaseController
{

    //put your code here

    const URL = 'http://localhost/api_siskeudes/public/index.php/api/';
    private Client $Client;

    public function __construct()
    {
        parent::__construct();
        $this->Client = new Client(['base_uri' => static::URL]);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public final function getRekening()
    {
        try {
            $response = $this->Client->request('GET', 'referensi/rekening');
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return json_decode($responseBodyAsString, true);
        }
    }

    public final function getLokasi()
    {
        try {
            $response = $this->Client->request('GET', 'referensi/lokasi');
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return json_decode($responseBodyAsString, true);
        }
    }

    public final function getPerencanaanBidang(string $tahun, string $kd_kec)
    {
        try {
            $response = $this->Client->request('GET', 'perencanaan/bidang',
                ['query' =>
                    ['tahun' => $tahun, 'kecamatan' => $kd_kec]
                ]
            );
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return print_r($responseBodyAsString);
        }
    }

    public final function getRab($tahun, $kd_kec)
    {
        try {
            $response = $this->Client->request('GET', 'perencanaan/rab',
                ['query' =>
                    ['tahun' => $tahun, 'kecamatan' => $kd_kec]
                ]
            );
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return print_r($responseBodyAsString);
        }
    }


    public final function getSpp($tahun, $kd_kec)
    {
        try {
            $response = $this->Client->request('GET', 'spp',
                ['query' =>
                    ['tahun' => $tahun, 'kecamatan' => $kd_kec]
                ]
            );
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            #guzzle repose for future use
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return print_r($responseBodyAsString);
        }
    }

    function getSpj($tahun, $kd_kec)
    {
        try {
            $response = $this->Client->request('GET', 'spj',
                ['query' =>
                    ['tahun' => $tahun, 'kecamatan' => $kd_kec]
                ]
            );
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (ClientException $e) {
            #guzzle repose for future use
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return print_r($responseBodyAsString);
        }
    }
}
