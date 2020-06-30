<?php

if(empty($dados['logradouro']) || $dadosOld['rua'] !== $dados['rua'] || $dadosOld['bairro'] !== $dados['bairro'] || $dadosOld['cep'] !== $dados['cep'] || $dadosOld['cidade'] !== $dados['cidade']) {
    $endereco['logradouro'] = $dados['rua'] . " - " . $dados['bairro'] . ", " . $dados['cidade'] . " - " . $dados['estado'] . ", " . $dados['cep'] . ", " . $dados['pais'];

    $up = new \Conn\Update();
    $up->exeUpdate("endereco", $endereco, "WHERE id =:id", "id={$dados['id']}");
}