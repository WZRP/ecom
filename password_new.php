<?php
include 'includes/session.php';

if (isset($_POST['reset'])) {
	$reset_code = $_POST['reset_code'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];

	if ($password != $repassword) {
		$_SESSION['error'] = 'Passwords did not match';
		header('location: password_new.php');
	} else {
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT id, COUNT(*) AS numrows FROM users WHERE reset_code=:code");
		$stmt->execute(['code' => $reset_code]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {
			$password = password_hash($password, PASSWORD_DEFAULT);

			try {
				$stmt = $conn->prepare("UPDATE users SET password=:password WHERE id=:id");
				$stmt->execute(['password' => $password, 'id' => $row['id']]);

				$_SESSION['success'] = 'Password successfully reset';
				header('location: login.php');
			} catch (PDOException $e) {
				$_SESSION['error'] = $e->getMessage();
				header('location: password_new.php');
			}
		} else {
			$_SESSION['error'] = 'Invalid reset code';
			header('location: password_new.php');
		}
	}
} else {
	$_SESSION['error'] = 'Input new password first';
	header('location: password_new.php');
}
