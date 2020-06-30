<?php

$endereco['logradouro'] = $dados['rua'] . " - " . $dados['bairro'] . ", " . $dados['cidade'] . " - " . $dados['estado'] . ", " . $dados['cep'] . ", " . $dados['pais'];
$up = new \Conn\Update();
$up->exeUpdate("endereco", $endereco, "WHERE id =:id", "id={$dados['id']}");
