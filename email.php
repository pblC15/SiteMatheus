<?php

// Define o fuso horário para a data
date_default_timezone_set("America/Sao_Paulo");

require ('src/PHPMailer.php');
require ('src/SMTP.php');
require ('src/Exception.php');

// Importando o namespace das classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Credenciais de SMTP: NUNCA deixe usuário/senha escritos direto no código.
// Configure-as em config.php (que não deve ser versionado nem enviado a
// ninguém) ou, preferencialmente, como variáveis de ambiente do servidor.
$config = __DIR__ . '/config.php';
if (file_exists($config)) {
    require $config; // deve definir SMTP_USER, SMTP_PASS e MAIL_TO
}

$smtpUser = getenv('SMTP_USER') ?: (defined('SMTP_USER') ? SMTP_USER : '');
$smtpPass = getenv('SMTP_PASS') ?: (defined('SMTP_PASS') ? SMTP_PASS : '');
$mailTo   = getenv('MAIL_TO')   ?: (defined('MAIL_TO') ? MAIL_TO : $smtpUser);

if (isset($_POST['f_btn'])) {

    // Verifica se os campos obrigatórios foram preenchidos
    if ((isset($_POST['f_user']) && !empty(trim($_POST['f_user'])))
        && (isset($_POST['f_email']) && !empty(trim($_POST['f_email'])))
        && (isset($_POST['f_message']) && !empty(trim($_POST['f_message'])))
    ) {

        // Sanitiza os dados recebidos antes de usá-los (evita injeção de
        // cabeçalhos de e-mail e XSS no corpo da mensagem)
        $user    = htmlspecialchars(trim($_POST['f_user']), ENT_QUOTES, 'UTF-8');
        $email   = filter_var(trim($_POST['f_email']), FILTER_SANITIZE_EMAIL);
        $phone   = htmlspecialchars(trim($_POST['f_tel'] ?? 'Não informado'), ENT_QUOTES, 'UTF-8');
        $message = nl2br(htmlspecialchars(trim($_POST['f_message']), ENT_QUOTES, 'UTF-8'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.html?id=alert");
            exit;
        }

        if (empty($smtpUser) || empty($smtpPass)) {
            // Credenciais não configuradas no servidor
            header("Location: index.html?id=error");
            exit;
        }

        $mail = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtpUser;
            $mail->Password   = $smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($smtpUser, 'Site Matheus Fernandes Advocacia');
            $mail->addAddress($mailTo);
            $mail->addReplyTo($email, $user);

            $mail->isHTML(true);
            $mail->Subject = 'Mensagem de cliente através do site';
            $mail->Body    = '<div>'
                . '<p><strong>Cliente:</strong> ' . $user . '</p>'
                . '<p><strong>Email:</strong> ' . $email . '</p>'
                . '<p><strong>Telefone:</strong> ' . $phone . '</p>'
                . '<p><strong>Mensagem:</strong><br>' . $message . '</p>'
                . '</div>';

            if ($mail->send()) {
                header("Location: index.html?id=success");
            } else {
                header("Location: index.html?id=error");
            }
        } catch (Exception $e) {
            header("Location: index.html?id=error");
        }

    } else {
        header("Location: index.html?id=alert");
    }

} else {
    header("Location: index.html?id=alert");
}
