<?php
$setor = \Config\Config::getSetor();
$data['data'] = [];

$content = [
    "allow" => \Config\Config::getPermission()[$setor] ?? [],
    "dicionario" => \Entity\Entity::dicionario(),
    "info" => \Entity\Entity::info(),
    "template" => [],
    "menu" => [],
    "navbar" => [],
    "react" => [],
    "relevant" => [],
    "general" => [],
    "graficos" => []
];

include 'config/templates.php';
$content['template'] = $data['data'];

include 'config/menu.php';
$content['menu'] = $data['data'];

include 'config/navbar.php';
$content['navbar'] = $data['data'];

include 'config/react.php';
$content['react'] = $data['data'];

include 'config/relevant.php';
$content['relevant'] = $data['data'];

include 'config/general.php';
$content['general'] = $data['data'];

include 'config/graficos.php';
$content['graficos'] = $data['data'];

$data['data'] = $content;