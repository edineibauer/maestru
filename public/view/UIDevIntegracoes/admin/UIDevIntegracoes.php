<?php
$tpl = new \Helpers\Template("dev-ui");
$integ = [
    'integration' => [],
    'home' => HOME,
    'version' => VERSION,
    'vendor' => VENDOR
];
$dados = [];

if(file_exists(PATH_HOME . "_config/config.json"))
    $dados = json_decode(file_get_contents(PATH_HOME . "_config/config.json"), true);

if(file_exists(PATH_HOME . "public/integracoes")){
    foreach (\Helpers\Helper::listFolder(PATH_HOME . "public/integracoes") as $c) {
        $file = json_decode(file_get_contents(PATH_HOME . "public/integracoes/{$c}"), !0);
        foreach ($file['constantes'] as $nome => $column)
            $file['constantes'][$nome]['value'] = $dados[$file['constantes'][$nome]['column']] ?? "";

        $integ['integration'][] = $file;
    }
}

foreach (\Helpers\Helper::listFolder(PATH_HOME . VENDOR) as $item) {
    if(file_exists(PATH_HOME . VENDOR . $item . "/public/integracoes")){
        foreach (\Helpers\Helper::listFolder(PATH_HOME . VENDOR . $item . "/public/integracoes") as $c) {
            $file = json_decode(file_get_contents(PATH_HOME . VENDOR . $item . "/public/integracoes/{$c}"), true);
            foreach ($file['constantes'] as $nome => $column)
                $file['constantes'][$nome]['value'] = $dados[$file['constantes'][$nome]['column']] ?? "";

            $integ['integration'][] = $file;
        }
    }
}

echo $tpl->getShow('integracoes', $integ);