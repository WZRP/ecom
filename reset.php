<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'includes/session.php';

if (isset($_POST['reset'])) {
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

	if (!$email) {
		$_SESSION['error'] = 'Invalid email format';
		header('location: password_forgot.php');
		exit();
	}

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
	$stmt->execute(['email' => $email]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		//generate code
		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 15);
		try {
			$stmt = $conn->prepare("UPDATE users SET reset_code=:code WHERE id=:id");
			$stmt->execute(['code' => $code, 'id' => $row['id']]);

			$message = "
                    <h2>Password Reset</h2>
                    <p>Your Account:</p>
                    <p>Email: " . $email . "</p>
                    <p>Please use the following code to reset your password:</p>
                    <p>Reset Code: " . $code . "</p>
                ";

			//Load phpmailer
			require 'vendor/autoload.php';

			$mail = new PHPMailer(true);
			try {
				//Server settings
				$mail->isSMTP();
				$mail->Host = SMTP_HOST;
				$mail->SMTPAuth = true;
				$mail->Username = SMTP_USERNAME;
				$mail->Password = SMTP_PASSWORD;
				$mail->SMTPSecure = 'ssl';
				$mail->Port = 465;

				$mail->setFrom(SMTP_USERNAME);

				//Recipients
				$mail->addAddress($email);
				$mail->addReplyTo(SMTP_USERNAME);

				//Content
				$mail->isHTML(true);
				$mail->Subject = 'ECommerce Site Password Reset';
				$mail->Body    = $message;

				$mail->send();

				$_SESSION['success'] = 'Password reset code sent';
			} catch (Exception $e) {
				$_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
			}
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	} else {
		$_SESSION['error'] = 'Email not found';
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Input email associated with account';
}

header('location: password_forgot.php');
