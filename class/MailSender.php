<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender {
    private User $_user;

    public function __construct(User $user) {
        $this->_user = $user;
    }
    
    public function verify(string $url) {
        $email_body = new MailTemplate(__DIR__ . '/../mail/verify-inlined.html');
        $email_body->set('url', $url);
        $email_body->set('hostname', Config::URL_ROOT(false));
        $email_body->set('nickname', $this->_user->nickname());

        $mail = self::_base_mail();
        $email_address = $this->_user->new_email();

        if (!isset($email_address) || empty($email_address)){
            throw new MissingEmail('The user ' . $_user->nickname() . ' (' . $_user->id() . ') don\'t have an email!');
        }

        $mail->addAddress($email_address, $this->_user->nickname());
        $mail->isHTML(true);
        $mail->Subject = 'We need you to verify your email';
        $mail->Body = $email_body->output();
        $mail->send();
        // @todo need handle AltBody
    }

    private static function _base_mail() : PHPMailer {
        $mail = new PHPMailer();

        // Connection
        $mail->isSMTP();
        $mail->Host       = Config::SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = Config::SMTP_USER;
        $mail->Password   = Config::SMTP_PASS;
        $mail->SMTPSecure = Config::IS_SMTPS ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = Config::SMTP_PORT;

        // Recipient
        $mail->setFrom(Config::SMTP_FROM, 'OkyDoky');
        return $mail;
    }

    public static function test_connection(string $email) {
        $email_body = new MailTemplate(__DIR__ . '/../mail/verify-inlined.html');
        $email_body->set('url', "<strong>THIS IS JUST A TEST EMAIL</strong>");
        $email_body->set('hostname', Config::URL_ROOT(false));
        $email_body->set('nickname', '<strong>IS THAT YOU, ADMIN?</strong>');

        $mail = self::_base_mail();
        $mail->addAddress($email, "ADMIN");
        $mail->isHTML(true);
        $mail->Subject = 'TEST MAIL';
        $mail->Body = $email_body->output();

        $mail->send();

    }
}
