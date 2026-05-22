<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/security.php');
	
	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$saleDetailsSearchSql = 'SELECT * FROM sale';
	$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
	$saleDetailsSearchStatement->execute();

	$output = '<table id="saleReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Sale ID</th>
						<th>Item Number</th>
						<th>Customer ID</th>
						<th>Customer Name</th>
						<th>Item Name</th>
						<th>Sale Date</th>
						<th>Discount %</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$uPrice = $row['unitPrice'];
		$qty = $row['quantity'];
		$discount = $row['discount'];
		$totalPrice = $uPrice * $qty * ((100 - $discount)/100);
		
		$output .= '<tr>' .
						'<td>' . e($row['saleID']) . '</td>' .
						'<td>' . e($row['itemNumber']) . '</td>' .
						'<td>' . e($row['customerID']) . '</td>' .
						'<td>' . e($row['customerName']) . '</td>' .
						'<td>' . e($row['itemName']) . '</td>' .
						'<td>' . e($row['saleDate']) . '</td>' .
						'<td>' . e($row['discount']) . '</td>' .
						'<td>' . e($row['quantity']) . '</td>' .
						'<td>' . e($row['unitPrice']) . '</td>' .
						'<td>' . e($totalPrice) . '</td>' .
					'</tr>';
	}
	
	$saleDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>


