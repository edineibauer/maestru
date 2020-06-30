<?php
$field = strtolower(trim(strip_tags(filter_input(INPUT_POST, "field", FILTER_DEFAULT))));
$value = trim(strip_tags(filter_input(INPUT_POST, "value", FILTER_DEFAULT)));

//Abre json config and add/update field
$config = json_decode(file_get_contents(PATH_HOME . "_config/config.json"), !0);
$config[$field] = str_replace("'", '"', $value);

Config\Config::createConfig($config);