<?php

$dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

$f = fopen(PATH_HOME . "_config/permissoes.json", "w+");
fwrite($f, json_encode($dados));
fclose($f);