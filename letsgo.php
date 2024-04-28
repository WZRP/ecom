<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'secret.php';
include 'includes/session.php';

$conn = $pdo->open();

if (isset($_POST['signup'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if ($password != $repassword) {
        $_SESSION['error'] = 'Passwords did not match';
        echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
        unset($_SESSION['error']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error'] = 'Email already taken';
        echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
        unset($_SESSION['error']);
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $code = strval(rand(100000, 999999));
    $_SESSION['verification_code'] = $code;
    $now = date('Y-m-d');

    try {
        $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on, status) VALUES (:email, :password, :firstname, :lastname, :code, :now, 'pending')");
        $stmt->execute(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'code' => $code, 'now' => $now]);
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom(SMTP_USERNAME, 'ECommerce Site');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'ECommerce Site Sign Up';
        $mail->Body = "Thank you for registering. Your verification code is: $code";
        $mail->send();
        $_SESSION['success'] = 'Account created. Check your email to activate.';
        echo json_encode(['success' => true, 'message' => $_SESSION['success']]);
        unset($_SESSION['success']);
    } catch (Exception $e) {
        $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
        unset($_SESSION['error']);
    }
    exit;
} elseif (isset($_POST['verify'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email AND activate_code=:code");
    $stmt->execute(['email' => $_POST['email'], 'code' => strval($_POST['code'])]);
    $user = $stmt->fetch();

    if ($user && $_SESSION['verification_code'] == $_POST['code']) {
        $stmt = $conn->prepare("UPDATE users SET status='1' WHERE email=:email");
        $stmt->execute(['email' => $_POST['email']]);
        unset($_SESSION['verification_code']);
        echo json_encode(['success' => true, 'message' => 'Verification successful']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Verification failed']);
        exit;
    }
} else {
    $_SESSION['error'] = 'Fill up signup form first';
    echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
    unset($_SESSION['error']);
}
$pdo->close();
