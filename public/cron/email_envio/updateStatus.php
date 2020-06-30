<?php

// 5 min Update Status email

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

//deprecated
die;

if(defined('EMAILKEY') && !empty(EMAILKEY)) {
    $httpClient = new GuzzleAdapter(new Client());
    $sparky = new SparkPost($httpClient, ["key" => EMAILKEY]);
    $read = new \Conn\Read();
    $up = new \Conn\Update();

    $read->exeRead("email_envio", "WHERE (email_clicado = 0 || email_clicado IS NULL) && (email_error = 0 || email_error IS NULL)");
    if ($read->getResult()) {
        $ids = [];
        foreach ($read->getResult() as $email)
            $ids[] = $email['transmission_id'];

        $conv = [
            "delivery" => "email_entregue",
            "open" => "email_aberto",
            "click" => "email_clicado",
            "spam_complaint" => "email_spam",
        ];

        if (!empty($ids)) {
            $promise = $sparky->request('GET', 'message-events', [
                'transmission_ids' => $ids,
                'events' => array_keys($conv)
            ]);
            try {
                $response = $promise->wait();
                if ($response->getStatusCode() === 200 && !empty($response->getBody())) {
                    $response = $response->getBody()['results'];
                    $dados = [];

                    foreach ($response as $item)
                        $dados[$item['transmission_id']][$conv[$item['type']]] = 1;

                    if (!empty($dados)) {
                        foreach ($dados as $id => $dado)
                            $up->exeUpdate("email_envio", $dado, "WHERE transmission_id = :id", "id={$id}");
                    }
                }
            } catch (\Exception $e) {
                echo $e->getCode() . "\n";
                echo $e->getMessage() . "\n";
            }
        }
    }
}