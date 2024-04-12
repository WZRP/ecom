<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <?php
    if (isset($_SESSION['error'])) {
      echo "
          <div class='callout callout-danger text-center'>
            <p>" . $_SESSION['error'] . "</p> 
          </div>
        ";
      unset($_SESSION['error']);
    }
    ?>
    <div class="login-box-body">
      <p class="login-box-msg">Enter your reset code</p>

      <form action="password_new.php" method="POST">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="reset_code" placeholder="Reset Code" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit"><i class="fa fa-check-square-o"></i> Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include 'includes/scripts.php' ?>
</body>

</html>