<?php

/**
 * Read table token and remove token access
 */
$data['data'] = "";
$read = new \Conn\Read();
$read->exeRead("usuarios_token", "WHERE token = :t", "t={$_SESSION['userlogin']['token']}");
if($read->getResult()) {
    $del = new \Conn\Delete();
    $del->exeDelete("usuarios_token", "WHERE token = :t", "t={$_SESSION['userlogin']['token']}");
    $data['data'] = "1";
}