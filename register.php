<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include 'includes/session.php';

if (isset($_POST['signup'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if ($password != $repassword) {
        $_SESSION['error'] = 'Passwords did not match';
        header('location: signup.php');
    } else {
        $conn = $pdo->open();

        $stmt = $conn->prepare("UPDATE users SET password=:password, status='1' WHERE email=:email");
        $stmt->execute(['email' => $email, 'password' => $password]);
        $row = $stmt->fetch();
        if ($row['numrows'] > 0) {
            $_SESSION['error'] = 'Email already taken';
            header('location: signup.php');
        } else {
            $now = date('Y-m-d');
            $password = password_hash($password, PASSWORD_DEFAULT);

            // Generate a 6-digit code
            $code = rand(100000, 999999);

            $_SESSION['verification_code'] = $code;

            try {
                $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) VALUES (:email, :password, :firstname, :lastname, :code, :now)");
                $stmt->execute(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'code' => $code, 'now' => $now]);
                $userid = $conn->lastInsertId();

                $message = "
                    <h2>Thank you for Registering.</h2>
                    <p>Your Account:</p>
                    <p>Email: " . $email . "</p>
                    <p>Please use the following code to activate your account:</p>
                    <h3>" . $code . "</h3>
                ";

                //Load phpmailer
                require 'vendor/autoload.php';

                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = getenv('SMTP_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('SMTP_EMAIL');
                    $mail->Password = getenv('SMTP_PASSWORD');
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom(getenv('SMTP_EMAIL'));

                    //Recipients
                    $mail->addAddress($email);
                    $mail->addReplyTo(getenv('SMTP_EMAIL'));

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'ECommerce Site Sign Up';
                    $mail->Body    = $message;

                    $mail->send();

                    $_SESSION['success'] = 'Account created. Check your email to activate.';
                    header('location: signup.php');
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                    header('location: signup.php');
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('location: register.php');
            }

            $pdo->close();
        }
    }
} else {
    $_SESSION['error'] = 'Fill up signup form first';
    header('location: signup.php');
}
