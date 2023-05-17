<?php

function enkripsiText($text) {
    $encrypter = \Config\Services::encrypter();
    return $encrypter->encrypt($text);
}

function deskripsiText($text) {
    $encrypter = \Config\Services::encrypter();
    return $encrypter->decrypt($text);
}

if (! function_exists('encodeUrl')) {
    function encodeUrl(string $string = null): string
    {
        $encrypter = \Config\Services::encrypter();
        $entext = base64_encode($encrypter->encrypt($string));
        $enc = strtr($entext, '+/=', '-_,');
        return (string)$enc;
    }

}
function decodeUrl(string $string = null): string
{
    $dec = '';
    if (!empty($string)) {
        $encrypter = \Config\Services::encrypter();
        $detext = strtr($string, '-_,', '+/=');
        $dec = $encrypter->decrypt(base64_decode($detext));
    }
    return (string) $dec;
}
