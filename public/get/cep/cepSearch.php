<?php

$cep = $variaveis[0];

/**
 * Cria Cidade, Cep e Coordenadas
 * retorna id da Cidade Criada ou existente
 *
 * @param string $cep
 * @param string $bairro
 * @param string $rua
 * @param string $cidade
 * @param string $estado
 * @param string $pais
 * @param string $latitude
 * @param string $longitude
 * @param string $ddd
 * @param string $ibge
 * @param string $altitude
 * @return int
 */
function createCidadeAndCep(string $cep, string $bairro, string $rua, string $cidade, string $estado, string $pais, string $latitude, string $longitude, string $ddd, string $ibge, string $altitude)
{

    if (!empty($cep)) {
        $create = new \Conn\Create();
        if (!empty($latitude) && !empty($longitude)) {
            $read = new \Conn\Read();
            $read->exeRead("coordenadas", "WHERE cep = :cep", "cep={$cep}");
            if (!$read->getResult()) {
                $create->exeCreate("coordenadas", [
                    "cep" => $cep,
                    "latitude" => $latitude,
                    "longitude" => $longitude
                ]);
            }
        }

        $create->exeCreate("cep", [
            "cep" => $cep,
            "cidade" => $cidade,
            "estado" => $estado,
            "pais" => $pais,
            "bairro" => $bairro,
            "rua" => $rua,
            "ddd" => $ddd,
            "ibge" => $ibge,
            "altitude" => $altitude,
        ]);
    }
}

/**
 * Busca em CEP aberto
 */
if (defined('CEPABERTO') && !empty(CEPABERTO)) {
    $retorno = \Cep\Cep::cepAberto($cep);
    if (!empty($retorno) && !empty($retorno['cidade']['nome'])) {
        /**
         * Teve retorno, faz o cadastro na base
         */
        $param = [
            "cep" => $retorno['cep'] ?? "",
            "cidade" => $retorno['cidade']['nome'] ?? "",
            "estado" => $retorno['estado']['sigla'] ?? "",
            "pais" => "BR",
            "bairro" => $retorno['bairro'] ?? "",
            "rua" => $retorno['logradouro'] ?? "",
            "latitude" => $retorno['latitude'] ?? "",
            "longitude" => $retorno['longitude'] ?? "",
            "ddd" => $retorno['cidade']['ddd'] ?? "",
            "ibge" => $retorno['cidade']['ibge'] ?? "",
            "altitude" => $retorno['altitude'] ?? ""
        ];

        createCidadeAndCep($param['cep'], $param['bairro'], $param['rua'], $param['cidade'], $param['estado'], $param['pais'], $param['latitude'], $param['longitude'], $param['ddd'], $param['ibge'], $param['altitude']);

        $data['data'] = $param;
    }
}

/**
 * Busca em GeoCode
 */
if (empty($data['data']) && defined('GEOCODE') && !empty(GEOCODE)) {
    $retorno = \Cep\Cep::cepGeoCode($cep);

    if (!empty($retorno)) {
        /**
         * Teve retorno faz o cadastro na base
         */

        //default parameters
        $param = [
            "cep" => "",
            "cidade" => "",
            "estado" => "",
            "pais" => "",
            "bairro" => "",
            "rua" => "",
            "latitude" => $retorno['geometry']['location']['lat'],
            "longitude" => $retorno['geometry']['location']['lng'],
            "ddd" => "",
            "ibge" => "",
            "altitude" => ""
        ];

        //find values in Google Geo Code $retorno content
        foreach ($retorno['address_components'] as $component) {
            if (in_array("postal_code", $component['types']))
                $param['cep'] = str_replace("-", "", $component['long_name']);
            elseif (in_array("route", $component['types']))
                $param['rua'] = $component['long_name'];
            elseif (in_array("sublocality_level_1", $component['types']))
                $param['bairro'] = $component['long_name'];
            elseif (in_array("administrative_area_level_2", $component['types']))
                $param['cidade'] = $component['long_name'];
            elseif (in_array("administrative_area_level_1", $component['types']))
                $param['estado'] = $component['short_name'];
            elseif (in_array("country", $component['types']))
                $param['pais'] = $component['short_name'];
        }

        createCidadeAndCep($param['cep'], $param['bairro'], $param['rua'], $param['cidade'], $param['estado'], $param['pais'], $param['latitude'], $param['longitude'], $param['ddd'], $param['ibge'], $param['altitude']);

        $data['data'] = $param;
    }
}