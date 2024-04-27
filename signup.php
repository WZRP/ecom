<?php include 'includes/session.php'; ?>
<?php
if (isset($_SESSION['user'])) {
  header('location: cart_view.php');
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition register-page">
  <div class="register-box">
    <?php
    if (isset($_SESSION['error'])) {
      echo "
          <div class='callout callout-danger text-center'>
            <p>" . htmlspecialchars($_SESSION['error']) . "</p> 
          </div>
        ";
      unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
      echo "
          <div class='callout callout-success text-center'>
            <p>" . htmlspecialchars($_SESSION['success']) . "</p> 
          </div>
        ";
      unset($_SESSION['success']);
    }
    ?>
    <div class="register-box-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="activate.php" method="POST">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="firstname" placeholder="Firstname" value="<?php echo (isset($_SESSION['firstname'])) ? htmlspecialchars($_SESSION['firstname']) : '' ?>" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="lastname" placeholder="Lastname" value="<?php echo (isset($_SESSION['lastname'])) ? htmlspecialchars($_SESSION['lastname']) : '' ?>" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['email'])) ? htmlspecialchars($_SESSION['email']) : '' ?>" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="verification_code" placeholder="Verification Code" required>
          <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        </div>
        <button type="button" id="send_verification_email" class="btn btn-primary">Send Verification Email</button>
        <hr>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="signup"><i class="fa fa-pencil"></i> Sign Up</button>
          </div>
        </div>
      </form>
      <br>
      <a href="login.php">I already have a membership</a><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
    </div>
  </div>

  <?php include 'includes/scripts.php' ?>

  <script>
    document.getElementById('send_verification_email').addEventListener('click', function() {
      var email = document.getElementsByName('email')[0].value;
      var password = document.getElementsByName('password')[0].value;
      var confirmPassword = document.getElementsByName('repassword')[0].value;
      var firstName = document.getElementsByName('firstname')[0].value;
      var lastName = document.getElementsByName('lastname')[0].value;

      if (!email || !email.includes('@') || email.length > 40) {
        alert('Please enter a valid email address.');
        return;
      } else if (!password || password.length < 8 || password.length > 40) {
        alert('Password must be between 8 and 40 characters.');
        return;
      } else if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
      } else if (!firstName || firstName.length > 40) {
        alert('First name must be less than 40 characters.');
        return;
      } else if (!lastName || lastName.length > 40) {
        alert('Last name must be less than 40 characters.');
        return;
      }

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'activate.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password) + '&firstname=' + encodeURIComponent(firstName) + '&lastname=' + encodeURIComponent(lastName));

      xhr.onload = function() {
        if (xhr.status === 200) {
          alert('A verification email has been sent to ' + email);
        } else {
          alert('An error occurred while sending the verification email');
        }
      };

      this.disabled = true;
      setTimeout(() => this.disabled = false, 60000);
    });
  </script>
</body>

</html>