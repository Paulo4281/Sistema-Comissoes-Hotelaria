<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailController extends Controller
{

    // FUNÇÃO RESPONSÁVEL POR RESGATAR AS CREDENCIAIS DE EMAIL CONTIDAS NO ARQUIVO emailConfig //
    
    public function getEmailCredentials() {

        $emailCredentials = array();

        $host = config('emailConfig.host');
            if ($host) {
                $emailCredentials[] = $host;
            }
        $emailUsername = config('emailConfig.username');
            if ($emailUsername) {
                $emailCredentials[] = $emailUsername;
            }
        $password = config('emailConfig.password');
            if ($password) {
                $emailCredentials[] = $password;
            }

        if ($emailCredentials) {
            return $emailCredentials;
        }

        return false;

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR ENVIAR O EMAIL DE CONFIRMAÇÃO AO USUÁRIO //

    public function enviarEmail($userEmail, $userName, $type) {

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);

        $emailCredentials = self::getEmailCredentials();

        try {

            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = "{$emailCredentials[0]}";
            $mail->SMTPAuth = true;
            $mail->Username = "{$emailCredentials[1]}";
            $mail->Password = "{$emailCredentials[2]}";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom("{$emailCredentials[0]}", "SUBJECT");
            $mail->addAddress("{$userEmail}", "{$userName}");

            $mail->isHTML(true);
            $mail->Subject = 'Código de confirmação.';

            $codigo = self::gerarCodigoConfirmacao();
            Session::put('codigo', $codigo);

            if ($type == 0) {
                $mail->Body = "<h2>Olá {$userName},</h2><br>Utilize o seguinte código para confirmar o seu cadastro.<br>{$codigo}";
            } else if ($type == 1) {
                $mail->Body = "<h2>Olá {$userName},</h2><br>Utilize o seguinte código para redefenir sua senha.<br>{$codigo}";
            }
            
            $mail->send();

        } catch (Exception $e) {
            // echo "Error: " . $e->ErrorInfo;
        }

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR GERAR O CÓDIGO DE CONFIRMAÇÃO //

    public function gerarCodigoConfirmacao() {

        $numeros = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $randomNumber = '';
        for ($i = 0; $i < 6; $i++) {
            $random = mt_rand(0, count($numeros) - 1);
            $randomNumber .= $numeros[$random];
        }

        return $randomNumber;

    }

    // ** //

    // FUNÇÕES RESPONSÁVEIS POR CHAMAR AS FUNÇÕES DE ENVIO DE EMAIL DE CONFIRMAÇÃO //

    public function enviarEmailConfirmacao($userEmail, $userName) {
        if (Session::has('username') && Session::has('user-email') && Session::has('verificar-codigo')) {
            self::enviarEmail($userEmail, $userName, 0); 
        }
    }

    public function enviarEmailRedefenirSenha($userEmail, $userName) {
        if (Session::has('username') && Session::has('user-email') && Session::has('redefenir-senha')) {
            self::enviarEmail($userEmail, $userName, 1);
        }
    }

    // ** //

}
