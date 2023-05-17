<?php

namespace App\Libraries;

use CodeIgniter\HTTP\ResponseInterface;
use JetBrains\PhpStorm\ArrayShape;

class ResponseLib
{

    public static function getStatusFalse(string $message, int $statusCode = ResponseInterface::HTTP_BAD_REQUEST, array|object $data = []): array
    {
        return array('message' => $message, 'status' => false, 'statusCode' => $statusCode, 'data' => $data);
    }

    public static function getStatusTrue(string $message = 'Success', int $statusCode = ResponseInterface::HTTP_OK, array|object $data = []): array
    {
        return array('message' => $message, 'status' => true, 'statusCode' => $statusCode, 'data' => $data);
    }

    public static function statusAction(string $message, bool $status): array
    {
        return ['status' => $status, 'message' => $message];
    }

}