<?php

if (defined("EMAIL")) {
    $read = new \Conn\Read();
    $read->exeRead("email_envio", "WHERE (email_enviado = 0 || email_enviado IS NULL) && email_error IS NULL && (data_de_envio <= NOW() || data_de_envio IS NULL) ORDER BY data_de_envio ASC");
    if ($read->getResult()) {

        $up = new \Conn\Update();

        // Para cada email disponível para ser enviado
        foreach ($read->getResult() as $email) {

            $emailSend = new \Email\Email();
            try {

                $emailSend->setDestinatarioEmail($email['email_destinatario']);
                $emailSend->setAssunto($email['assunto']);
                $emailSend->setMensagem($email['mensagem']);

                if (!empty($email['nome_destinatario']))
                    $emailSend->setDestinatarioNome($email['nome_destinatario']);

                if (!empty($email['template']))
                    $emailSend->setTemplate($email['template']);

                if (!empty($email['anexos']))
                    $emailSend->setAnexo($email['anexos']);

                $emailSend->setVariables([
                    'id' => $email['id'],
                    'image' => (!empty($email['imagem_capa']) ? HOME . json_decode($email['imagem_capa'], true)[0]['url'] : ""),
                    'background' => (!empty($email['background']) ? HOME . json_decode($email['background'], true)[0]['url'] : ""),
                    'btn' => !empty($email['texto_do_botao']) ? $email['texto_do_botao'] : "",
                    'link' => !empty($email['link_do_botao']) ? $email['link_do_botao'] : "",
                ]);

                $emailSend->enviar();

                if ($emailSend->getResult())
                    $resultData['transmission_id'] = $emailSend->getResult();

            } catch (Exception $e) {
                $emailSend->setError($e->getMessage());
            }

            if ($emailSend->getError())
                $resultData["email_error"] = 1;
            else
                $resultData["email_enviado"] = 1;

            $up->exeUpdate("email_envio", $resultData, "WHERE id = :id", "id={$email['id']}");
        }
    }
}