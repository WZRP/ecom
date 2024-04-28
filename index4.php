<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>

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

            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-0 gx-5 align-items-end">
                        <div class="col-lg-6">
                            <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                                <h1 class="display-5 mb-3">Our Fruits</h1>
                                <p>Enjoy our selection of the freshest and most delicious domestic and imported fruits.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                            <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary border-2 active" data-bs-toggle="pill" href="#tab-1">Domestic Fruits</a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary border-2" data-bs-toggle="pill" href="#tab-2">Imported Fruits</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <?php
                                $conn = $pdo->open();

                                try {
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = 1 ORDER BY name ASC");
                                    $stmt->execute();
                                    foreach ($stmt as $row) {
                                        $image = !empty($row['photo']) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                        $slug = str_replace(' ', '-', strtolower($row['name']));
                                        echo "
                                            <div class='col-xl-3 col-lg-4 col-md-6 wow fadeInUp' data-wow-delay='0.1s'>
                                                <div class='product-item'>
                                                    <div class='position-relative bg-light overflow-hidden'>
                                                        <img class='img-fluid w-100' src='" . $image . "' alt=''>
                                                        <div class='bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3'>New</div>
                                                    </div>
                                                    <div class='text-center p-4'>
                                                        <a class='d-block h5 mb-2' href='product.php?product=" . $slug . "'>" . $row['name'] . "</a>
                                                        <span class='text-primary me-1'>$" . number_format($row['price'], 0) . "</span>
                                                    </div>
                                                    <div class='d-flex border-top'>
                                                        <small class='w-50 text-center border-end py-2'>
                                                            <a class='text-body' href='product.php?product=" . $slug . "'><i class='fa fa-eye text-primary me-2'></i>View detail</a>
                                                        </small>
                                                        <small class='w-50 text-center py-2'>
                                                            <a class='text-body' href='#'><i class='fa fa-shopping-bag text-primary me-2'></i>Add to cart</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                } catch (PDOException $e) {
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }

                                $pdo->close();
                                ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <?php
                                $conn = $pdo->open();

                                try {
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = 2 ORDER BY name ASC");
                                    $stmt->execute();
                                    foreach ($stmt as $row) {
                                        $image = !empty($row['photo']) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                        $slug = str_replace(' ', '-', strtolower($row['name']));
                                        echo "
                                            <div class='col-xl-3 col-lg-4 col-md-6 wow fadeInUp' data-wow-delay='0.1s'>
                                                <div class='product-item'>
                                                    <div class='position-relative bg-light overflow-hidden'>
                                                        <img class='img-fluid w-100' src='" . $image . "' alt=''>
                                                        <div class='bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3'>New</div>
                                                    </div>
                                                    <div class='text-center p-4'>
                                                        <a class='d-block h5 mb-2' href='product.php?product=" . $slug . "'>" . $row['name'] . "</a>
                                                        <span class='text-primary me-1'>$" . number_format($row['price'], 0) . "</span>
                                                    </div>
                                                    <div class='d-flex border-top'>
                                                        <small class='w-50 text-center border-end py-2'>
                                                            <a class='text-body' href='product.php?product=" . $slug . "'><i class='fa fa-eye text-primary me-2'></i>View detail</a>
                                                        </small>
                                                        <small class='w-50 text-center py-2'>
                                                            <a class='text-body' href='#'><i class='fa fa-shopping-bag text-primary me-2'></i>Add to cart</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                } catch (PDOException $e) {
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }

                                $pdo->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>

</html>