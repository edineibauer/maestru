<?php

namespace Cep;

class Cep
{

    /**
     * Busca CEP no Cep Aberto e retorna dados
     *
     * @param string $cep
     * @return string
     */
    public static function cepAberto(string $cep)
    {
        if (defined("CEPABERTO")) {
            $url = 'https://www.cepaberto.com/api/v3/cep?cep=' . $cep;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . CEPABERTO . '"'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            return json_decode(curl_exec($ch), !0);
        }
        return 'token CEP ABERTO não definido';
    }

    /**
     * Busca CEP no google Geo Code e retorna dados
     * @param string $cep
     * @return bool|string
     */
    public static function cepGeoCode(string $cep)
    {
        if (defined("GEOCODE") && !empty(GEOCODE)) {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $cep . "&key=" . GEOCODE;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $result = json_decode(curl_exec($ch), !0);
            return ($result['status'] === "OK" ? $result['results'][0] : []);
        }
        return 'token GEO CODE não definido';
    }
}