<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'secret.php';

if (isset($_POST['send'])) {

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($email);
    $mail->isHTML(true);
    $mail->addAddress($_POST["email"]);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
    $mail->send();

    echo
    "
    <script>
    alert('Message has been sent');
    document.location.href = 'index2.php';
    </script>
    ";
}
