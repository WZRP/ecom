<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<head>
    <meta charset="utf-8">
    <title>UnetiFood</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar2.php'; ?>

        <div class="content-wrapper">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="images/ad1.webp" alt="First slide">
                    </div>
                    <div class="item">
                        <img src="images/ad2.webp" alt="Second slide">
                    </div>
                    <div class="item">
                        <img src="images/ad3.webp" alt="Third slide">
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="fa fa-angle-right"></span>
                </a>
            </div>

            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                                unset($_SESSION['error']);
                            }
                            ?>

                            <h2>All Products</h2>
                            <?php
                            $conn = $pdo->open();

                            try {
                                $inc = 4;
                                $stmt = $conn->prepare("SELECT * FROM products ORDER BY name ASC");
                                $stmt->execute();
                                foreach ($stmt as $row) {
                                    $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                    $inc = ($inc == 4) ? 1 : $inc + 1;
                                    if ($inc == 1) echo "<div class='row'>";
                                    echo "
                                        <div class='col-sm-3'>
                                            <div class='box box-solid'>
                                                <div class='box-body prod-body'>
                                                    <img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
                                                    <h5><a href='product.php?product=" . $row['slug'] . "'>" . $row['name'] . "</a></h5>
                                                </div>
                                                <div class='box-footer'>
                                                    <b>&#8363; " . number_format($row['price']) . "</b>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                    if ($inc == 4) echo "</div>";
                                }
                                if ($inc == 1) echo "<div class='col-sm-3'></div><div class='col-sm-3'></div><div class='col-sm-3'></div></div>";
                                if ($inc == 2) echo "<div class='col-sm-3'></div><div class='col-sm-3'></div></div>";
                                if ($inc == 3) echo "<div class='col-sm-3'></div></div>";
                            } catch (PDOException $e) {
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            $pdo->close();

                            ?>
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