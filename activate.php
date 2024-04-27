<?php
include 'includes/session.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$output = '';
$conn = $pdo->open();

if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'])) {
	// Check if user exists first
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->execute(['email' => $_POST['email']]);
	$user = $stmt->fetch();

	if (!$user) { // User doesn't exist, create a new record
		$code = bin2hex(random_bytes(3));
		$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on, status) 
                                VALUES (:email, :password, :firstname, :lastname, :code, :now, 'pending')");
		$stmt->execute([
			'email' => $_POST['email'],
			'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
			'firstname' => $_POST['first_name'],
			'lastname' => $_POST['last_name'],
			'code' => $code,
			'now' => date('Y-m-d')
		]);
	} else { // User exists, update the code 
		$code = bin2hex(random_bytes(3));
		$stmt = $conn->prepare("UPDATE users SET activate_code=:code WHERE email=:email");
		$stmt->execute(['code' => $code, 'email' => $_POST['email']]);
	}

	$mail = new PHPMailer(true);

	try {
		$mail->isSMTP();
		$mail->Host = $_ENV['SMTP_HOST'];
		$mail->SMTPAuth = true;
		$mail->Username = $_ENV['SMTP_EMAIL'];
		$mail->Password = $_ENV['SMTP_PASSWORD'];
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom($_ENV['SMTP_EMAIL'], 'Mailer');
		$mail->addAddress($_POST['email'], 'User');     // Add a recipient

		$mail->isHTML(true);  // Set email format to HTML
		$mail->Subject = 'Account Verification';
		$mail->Body    = 'Your verification code is: ' . $code;

		$mail->send();
		$output .= '
            
                 Success!
                We have sent a verification code to <b>' . $_POST['email'] . '</b>. 
            
            <h4>You may <a href="login.php">Login</a> or back to <a href="index.php">Homepage</a>.</h4>
        ';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

if (!isset($_POST['verification_code']) || strlen($_POST['verification_code']) !== 6) {
	$output .= '
    <div class="alert alert-danger">
        <h4><i class="icon fa fa-warning"></i> Error!</h4>
        Please enter a valid verification code.
    </div>
    <h4>You may <a href="signup.php">Signup</a> or back to <a href="index.php">Homepage</a>.</h4>
  ';
	echo $output;
	exit;
}

if (isset($_POST['verification_code'])) {
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->execute(['email' => $_POST['email']]);
	$user = $stmt->fetch();

	if ($user['activate_code'] == $_POST['verification_code']) {
		$stmt = $conn->prepare("UPDATE users SET status='1' WHERE email=:email");
		$stmt->execute(['email' => $_POST['email']]);
		$output .= '
      <div class="alert alert-success">
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Your account has been activated. You may now <a href="login.php">Login</a>.
      </div>
    ';
	} else {
		$output .= '
      <div class="alert alert-danger">
        <h4><i class="icon fa fa-warning"></i> Error!</h4>
        The verification code is incorrect.
      </div>
    ';
	}
} elseif (isset($_POST['email'])) {
	$code = bin2hex(random_bytes(3));

	$stmt = $conn->prepare("UPDATE users SET activate_code=:code WHERE email=:email");
	$stmt->execute(['code' => $code, 'email' => $_POST['email']]);

	$mail = new PHPMailer(true);

	try {
		$mail->isSMTP();
		$mail->Host = $_ENV['SMTP_HOST'];
		$mail->SMTPAuth = true;
		$mail->Username = $_ENV['SMTP_EMAIL'];
		$mail->Password = $_ENV['SMTP_PASSWORD'];
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom($_ENV['SMTP_EMAIL'], 'Mailer');
		$mail->addAddress($_POST['email'], 'User');

		$mail->isHTML(true);
		$mail->Subject = 'Account Verification';
		$mail->Body    = 'Your verification code is: ' . $code;

		$mail->send();
		$output .= '
        <div class="alert alert-success">
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            We have sent a verification code to <b>' . $_POST['email'] . '</b>.
        </div>
        <h4>You may <a href="login.php">Login</a> or back to <a href="index.php">Homepage</a>.</h4>
      ';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
} else {
	$output .= '
    <div class="alert alert-danger">
        <h4><i class="icon fa fa-warning"></i> Error!</h4>
        Email to activate account not found.
    </div>
    <h4>You may <a href="signup.php">Signup</a> or back to <a href="index.php">Homepage</a>.</h4>
  ';
}

$pdo->close();
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">

				<section class="content">
					<div class="row">
						<div class="col-sm-12">
							<?php echo $output; ?>
						</div>
					</div>
				</section>

			</div>
		</div>

		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
</body>

</html>