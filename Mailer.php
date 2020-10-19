<?php
require "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailer
{

    function sendPassMail($id, $pass)
    {

        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = MAILER_HOST;
            $mail->Port = MAILER_PORT;
            $mail->SMTPAuth = true;
            $mail->Username = MAILER_USERNAME;
            $mail->Password = MAILER_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            $mail->setFrom(MAILER_SENDER_MAIL, MAILER_SENDER_NAME);
            $mail->addAddress($id . '@' . MAILER_RECIPIENT_MAIL_DOMAIN, $id);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = MAILER_SUBJECT;
            $mail->msgHTML($this->get_mail_body($pass));
            $mail->AltBody = "Your Password is " . $pass;

            if (!$mail->send()) {
                print $mail->ErrorInfo;
                return -1;
            }
            return 0;
        } catch (Exception $e) {
            print $e->getTraceAsString();
            return 1;
        }
    }

    function get_mail_body($pass)
    {
        $html = new DOMDocument();
        $html->loadHTMLFile('static/template.html');
        $res = str_replace('{{password}}', $pass, $html->saveHTML());
        foreach (MAIL_PARAM_ARRAY as $param => $value) {
            str_replace('{{'.$param.'}}', $value, $res);
        }
        return $res;
    }
}