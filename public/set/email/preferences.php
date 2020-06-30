<?php

$dados['assuntos'] = $_POST['assuntos'];
$dados['frequencia'] = filter_input(INPUT_POST, 'frequencia', FILTER_VALIDATE_INT);
$dados['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if(!empty($dados['email']) && !empty($dados['frequencia']) && !empty($dados['assuntos'])) {
/*
    $read = new \Conn\Read();
    $read->exeRead("email_list", "WHERE email = :em", "em={$dados['email']}");
    if($read->getResult())
        $dados['id'] = $read->getResult()[0]['id'];

    $d = new \EntityForm\Dicionario("email_list");
    $d->setData($dados);
    $d->save();
    */
    $data['data'] = 'ok';
}