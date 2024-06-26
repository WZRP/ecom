<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">

				<section class="content">
					<div class="row">
						<div class="col-sm-12">
							<?php

							$conn = $pdo->open();

							$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products WHERE name LIKE :keyword");
							$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);
							$row = $stmt->fetch();
							if ($row['numrows'] < 1) {
								echo '<h1 class="page-header">No results found for <i>' . $_POST['keyword'] . '</i></h1>';
							} else {
								echo '<h1 class="page-header">Search results for <i>' . $_POST['keyword'] . '</i></h1>';
								try {
									$inc = 4;
									$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :keyword");
									$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);

									foreach ($stmt as $row) {
										$highlighted = preg_filter('/' . preg_quote($_POST['keyword'], '/') . '/i', '<b>$0</b>', $row['name']);
										$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
										$inc = ($inc == 4) ? 1 : $inc + 1;
										if ($inc == 1) {
											echo "<div class='row'>";
										}
										echo "
											<div class='col-sm-3'>
												<div class='box box-solid'>
													<div class='box-body prod-body'>
														<img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
														<h5><a href='product.php?product=" . $row['slug'] . "'>" . $highlighted . "</a></h5>
													</div>
													<div class='box-footer'>
														<b>&#8363; " . number_format($row['price']) . "</b>
													</div>
												</div>
											</div>
										";
										if ($inc == 4) {
											echo "</div>";
										}
									}
									if ($inc == 1) {
										echo "<div class='col-sm-3'></div><div class='col-sm-3'></div><div class='col-sm-3'></div></div>";
									}
									if ($inc == 2) {
										echo "<div class='col-sm-3'></div><div class='col-sm-3'></div></div>";
									}
									if ($inc == 3) {
										echo "<div class='col-sm-3'></div></div>";
									}
								} catch (PDOException $e) {
									echo "There is some problem in connection: " . $e->getMessage();
								}
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