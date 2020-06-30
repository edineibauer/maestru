<?php

namespace Email;

class EmailEnvio
{
    private $destinatarioEmail;
    private $destinatarioNome;
    private $assunto;
    private $mensagem;
    private $dataEnvio;
    private $imagem;
    private $background;
    private $btnLink;
    private $btnText;
    private $anexos;
    private $template;

    /**
     * @param mixed $anexos
     */
    public function setAnexos($anexos): void
    {
        $this->anexos = $anexos;
    }

    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto): void
    {
        $this->assunto = $assunto;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background): void
    {
        $this->background = $background;
    }

    /**
     * @param mixed $dataEnvio
     */
    public function setDataEnvio($dataEnvio): void
    {
        $this->dataEnvio = $dataEnvio;
    }

    /**
     * @param mixed $btnLink
     */
    public function setBtnLink($btnLink): void
    {
        $this->btnLink = $btnLink;
    }

    /**
     * @param mixed $btnText
     */
    public function setBtnText($btnText): void
    {
        $this->btnText = $btnText;
    }

    /**
     * @param mixed $destinatarioEmail
     */
    public function setDestinatarioEmail($destinatarioEmail): void
    {
        $this->destinatarioEmail = $destinatarioEmail;
    }

    /**
     * @param mixed $destinatarioNome
     */
    public function setDestinatarioNome($destinatarioNome): void
    {
        $this->destinatarioNome = $destinatarioNome;
    }

    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem): void
    {
        $this->imagem = $imagem;
    }

    /**
     * @param mixed $mensagem
     */
    public function setMensagem($mensagem): void
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template): void
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getAnexos()
    {
        return $this->anexos;
    }

    /**
     * @return mixed
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @return mixed
     */
    public function getBtnLink()
    {
        return $this->btnLink;
    }

    /**
     * @return mixed
     */
    public function getBtnText()
    {
        return $this->btnText;
    }

    /**
     * @return mixed
     */
    public function getDestinatarioEmail()
    {
        return $this->destinatarioEmail;
    }

    /**
     * @return mixed
     */
    public function getDestinatarioNome()
    {
        return $this->destinatarioNome;
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function enviar()
    {
        if (!empty($this->destinatarioEmail)) {
            $teste = new \Conn\Read();
            $teste->exeRead("email_envio", "WHERE email_destinatario = '{$this->destinatarioEmail}' && assunto = '{$this->assunto}' && mensagem = '{$this->mensagem}'");
            if(!$teste->getResult()) {
                $emailEnvio = new \Entity\Dicionario('email_envio');
                $dados = [
                    'email_destinatario' => $this->destinatarioEmail,
                    'nome_destinatario' => $this->destinatarioNome ?? "",
                    'assunto' => $this->assunto,
                    'mensagem' => $this->mensagem,
                    'data_de_envio' => $this->dataEnvio ?? date("Y-m-d H:i:s")
                ];

                if ($this->btnLink)
                    $dados['link_do_botao'] = $this->btnLink;

                if ($this->btnText)
                    $dados['texto_do_botao'] = $this->btnText;

                if ($this->imagem)
                    $dados['imagem_capa'] = $this->imagem;

                if ($this->background)
                    $dados['background'] = $this->background;

                if ($this->anexos)
                    $dados['anexos'] = $this->anexos;

                if ($this->template)
                    $dados['template'] = $this->template;

                $emailEnvio->setData($dados);
                $emailEnvio->save();
            }
        }
    }
}