<?php

$dados['razao'] = filter_input(INPUT_POST, 'motivo', FILTER_VALIDATE_INT);
$dados['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if(!empty($dados['email']) && !empty($dados['razao'])) {
   /*
    $read = new \Conn\Read();
    $read->exeRead("email_blacklist", "WHERE email = :em", "em={$dados['email']}");
    if($read->getResult()) {
        $del = new \Conn\Delete();
        $del->exeDelete("email_blacklist", "WHERE email = :mm", "mm={$dados['email']}");
    }

    $d = new \EntityForm\Dicionario("email_blacklist");
    $d->setData($dados);
    $d->save();
    */
    $data['data'] = 'ok';
}