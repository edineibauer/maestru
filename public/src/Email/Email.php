<?php

/**
 * Email [ MODEL ]
 * Modelo responável por configurar a SparkPost, validar os dados e disparar e-mails do sistema!
 *
 * @copyright (c) 2018, Edinei J. Bauer
 */

namespace Email;

use Conn\Read;
use Helpers\Check;
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Email
{
    private $assunto;
    private $mensagem;
    private $html;
    private $template;
    private $destinatarioNome;
    private $destinatarioEmail;
    private $anexo;
    private $variables;
    private $remetenteEmail;
    private $remetenteNome;

    private $replyToEmail;
    private $replyToNome;

    private $error;
    private $result;

    public function __construct()
    {
        $this->variables = [];
        if (defined("EMAIL")) {
            $this->remetenteNome = "Contato" . (defined('SITENAME') ? " " . SITENAME : "");
            $this->remetenteEmail = EMAIL;
            $this->destinatarioNome = "";
            $this->anexo = [];
            $this->assunto = "Contato " . (defined('SITENAME') ? SITENAME : "");
        } else {
            throw new \Exception("Email não definido");
        }
    }

    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = trim(strip_tags($assunto));
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem(string $mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @param string $nome
     */
    public function setDestinatarioNome(string $nome)
    {
        $this->destinatarioNome = trim(strip_tags($nome));
    }

    /**
     * @param int $template
     */
    public function setTemplate(int $template)
    {
        $this->template = $template;
    }

    /**
     * Seta Variáveis para os templates
     * @param array $variables
     */
    public function setVariables(array $variables = [])
    {
        $this->variables = array_merge($this->variables, $variables);
    }

    /**
     * @param string|array $email
     */
    public function setDestinatarioEmail($email)
    {
        if (!empty($email)) {
            if (is_array($email)) {
                if (isset($email['email'])) {
                    if (!empty($email['name'])) {
                        $this->destinatarioEmail[] = ['address' => [
                            'name' => trim(strip_tags($email['name'])),
                            'email' => trim($email['email'])
                        ]];
                    } else {
                        $this->destinatarioEmail[] = ['address' => ['name' => $this->prepareNameFromEmail($email['email']), 'email' => trim($email['email'])]];
                    }
                } else {
                    foreach ($email as $item) {
                        if (is_array($item) && !empty($item['email']) && Check::email($item['email'])) {
                            if (!empty($item['name'])) {
                                $this->destinatarioEmail[] = ['address' => [
                                    'name' => trim(strip_tags($item['name'])),
                                    'email' => trim(strip_tags($item['email']))
                                ]];
                            } else {
                                $this->destinatarioEmail[] = ['address' => ['email' => trim($item['email'])]];
                            }
                        } elseif (is_string($item) && Check::email($item)) {
                            $this->destinatarioEmail[] = ['address' => ['name' => $this->prepareNameFromEmail($item), 'email' => trim($item)]];
                        }
                    }
                }
            } elseif (is_string($email) && Check::email($email)) {
                $this->destinatarioEmail[] = ['address' => ['name' => $this->prepareNameFromEmail($email), 'email' => trim($email)]];
            }
        }
    }

    /**
     * @param string $emailRemetente
     */
    public function setRemetenteEmail(string $emailRemetente)
    {
        $this->remetenteEmail = trim(strip_tags($emailRemetente));
    }

    /**
     * @param string $nomeRemetente
     */
    public function setRemetenteNome(string $nomeRemetente)
    {
        $this->remetenteNome = trim(strip_tags($nomeRemetente));
    }

    /**
     * @param string $replyToEmail
     */
    public function setReplyToEmail(string $replyToEmail)
    {
        $this->replyToEmail = trim(strip_tags($replyToEmail));
    }

    /**
     * @param string $replyToNome
     */
    public function setReplyToNome(string $replyToNome)
    {
        $this->replyToNome = trim(strip_tags($replyToNome));
    }

    /**
     * Recebe string json com informações do(s) anexo(s)
     * @param string $file
     */
    public function setAnexo(string $file)
    {
        $anexos = json_decode($file, true);
        if (is_array($anexos)) {
            foreach ($anexos as $anexo) {
                $this->anexo[] = [
                    "name" => $anexo['name'],
                    "type" => $anexo['type'],
                    "data" => base64_encode(file_get_contents(PATH_HOME . $anexo['url']))
                ];
            }
        }
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Envia Email
     */
    public function enviar()
    {
        if (!empty($this->assunto) && !empty($this->destinatarioEmail) && !empty($this->mensagem)) {
            //informações básicas presentes

            $this->html = $this->getTemplateHtml();

            //verifica meio de envio
            if (defined("EMAILKEY") && !empty(EMAILKEY) && defined("EMAIL") && !empty(EMAIL)) {

                //sparkpost ativo no sistema, utiliza-o para envio
                $this->sparkPost();

            } else {
                if (defined("EMAIL") && !empty(EMAIL))
                    $this->error = "Nenhum sistema de envio de email ativo. Vá em Integrações no menu de Dashboard e Ative SparkPost.";
                else
                    $this->error = "Email de Envio não identificado.";
            }
        }
    }

    /**
     * Obtém o HTML do email
     *
     * @return string
     */
    public function getEmailContent(): string
    {
        if (!empty($this->assunto) && !empty($this->destinatarioEmail) && !empty($this->mensagem))
            return $this->getTemplateHtml();

        return "";
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function sparkPost()
    {
        try {
            $httpClient = new GuzzleAdapter(new Client());
            $sparky = new SparkPost($httpClient, ['key' => EMAILKEY, 'async' => false]);

            $response = $sparky->transmissions->post([
                'content' => [
                    'from' => ['name' => $this->remetenteNome, 'email' => $this->remetenteEmail],
                    'subject' => $this->assunto,
                    'html' => $this->html,
                    'text' => trim(strip_tags($this->mensagem)),
                    'attachments' => $this->anexo,
                ],
                'recipients' => $this->destinatarioEmail
            ]);

            if ($response->getStatusCode() === 200)
                $this->result = $response->getBody()['results']['id'];
            else
                $this->error = $response->getStatusCode();

        } catch (\Exception $e) {
            $this->error = 'Erro Inexperado ao enviar';
        }
    }

    /**
     * Retorna estrutura HTML com variáveis aplicada no template
     * @return string
     */
    private function getTemplateHtml(): string
    {
        /*if ($this->template) {
            $read = new Read();
            $read->exeRead("email_template", "WHERE id = :id", "id={$this->template}");
            if ($read->getResult()) {
                $url = json_decode($read->getResult()[0]['template'], true)[0]['url'];
                $template = pathinfo($url, PATHINFO_BASENAME);
                $dirTemplate = pathinfo($url, PATHINFO_DIRNAME);
            }
        }*/

//        if (!isset($template)) {
            $dirTemplate = PATH_HOME . VENDOR . "email/public/tpl/model";
            $template = "content.tpl";
//        }

        $this->setVariables($this->getVariablesDefault());

        $this->variables['content'] = $this->getContent($dirTemplate, $template);

        return $this->getHtml();

    }

    /**
     * Retorna o Content (corpo) do email
     * @param string $dir
     * @param string $template
     * @return string
     */
    private function getContent(string $dir, string $template): string
    {
        try {
            $smart = new \Smarty();
            $smart->setTemplateDir($dir);

            foreach ($this->variables as $name => $value)
                $smart->assign($name, $value);

            $retorno = $smart->fetch($template);
            $smart->clearAllAssign();

            return $retorno;

        } catch (\Exception $e) {
            $this->error = "Smarty Template Error: {$e->getMessage()}";
        }

        return "";
    }

    /**
     * Obtém o Html para email
     * @return string
     */
    private function getHtml(): string
    {
        try {
            $smart = new \Smarty();
            $smart->setTemplateDir(PATH_HOME . VENDOR . "email/public/tpl/model");

            foreach ($this->variables as $name => $value)
                $smart->assign($name, $value);

            $retorno = $smart->fetch("base.tpl");
            $smart->clearAllAssign();

            return $retorno;

        } catch (\Exception $e) {
            $this->error = "Smarty Template Error: {$e->getMessage()}";
        }

        return "";
    }

    /**
     * Retorna dados padrão para passar para templates
     * @return array
     */
    private function getVariablesDefault(): array
    {
        list($color, $background) = $this->getColorTheme();
        return [
            "assunto" => $this->assunto,
            "mensagem" => $this->mensagem,
            "destinatarioEmail" => $this->destinatarioEmail[0]['address']['email'],
            "destinatarioNome" => $this->destinatarioNome,
            "remetenteEmail" => $this->remetenteEmail,
            "remetenteNome" => $this->remetenteNome,
            "sitename" => defined('SITENAME') ? SITENAME : "",
            "home" => defined('HOME') ? HOME : "",
            "sitedesc" => defined('SITEDESC') ? SITEDESC : "",
            "sitesub" => defined('SITESUB') ? SITESUB : "",
            "logo" => defined('LOGO') ? LOGO : "",
            "favicon" => defined('FAVICON') ? FAVICON : "",
            "date" => date('d/m/Y H:i', strtotime('now')),
            "theme" => $color,
            "themeBackground" => $background
        ];
    }

    /**
     * Retorna um nome a partir do email
     * @param string $email
     * @return string
     */
    private function prepareNameFromEmail(string $email): string
    {
        return ucwords(str_replace(['.', '_'], ' ', explode('@', $email)[0]));
    }


    private function getColorTheme()
    {
        if (file_exists(PATH_HOME . "public/assets/theme.min.css")) {
            $theme = file_get_contents(PATH_HOME . "public/assets/theme.min.css");
            if (preg_match('/\.theme{/i', $theme)) {
                $theme = explode('.theme{', $theme)[1];
                $color = trim(explode('!important', explode('color:', $theme)[1])[0]);
                $backgroun = trim(explode('!important', explode('background-color:', $theme)[1])[0]);
                return [$color, $backgroun];
            }
        }

        return ["#111", "70bbd9"];
    }
}
