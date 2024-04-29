<?php
include 'includes/session.php';

function generateRow($from, $to, $conn)
{
	$contents = '';

	$stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id WHERE sales_date BETWEEN '$from' AND '$to' ORDER BY sales_date DESC");
	$stmt->execute();
	$total = 0;
	foreach ($stmt as $row) {
		$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
		$stmt->execute(['id' => $row['salesid']]);
		$amount = 0;
		foreach ($stmt as $details) {
			$subtotal = $details['price'] * $details['quantity'];
			$amount += $subtotal;
		}
		$total += $amount;
		$contents .= '
            <tr>
                <td>' . date('M d, Y', strtotime($row['sales_date'])) . '</td>
                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                <td>' . $row['pay_id'] . '</td>
                <td align="right">&#8363; ' . number_format($amount) . '</td>
            </tr>
            ';
	}

	$contents .= '
            <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="right"><b>&#8363; ' . number_format($total) . '</b></td>
            </tr>
        ';
	return $contents;
}

if (isset($_POST['print'])) {
	$ex = explode(' - ', $_POST['date_range']);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));
	$from_title = date('M d, Y', strtotime($ex[0]));
	$to_title = date('M d, Y', strtotime($ex[1]));

	$conn = $pdo->open();

	$content = generateRow($from, $to, $conn);

	// You can echo or use the $content variable here as per your requirement

	$pdo->close();
} else {
	$_SESSION['error'] = 'Need date range to provide sales print';
	header('location: sales.php');
}
