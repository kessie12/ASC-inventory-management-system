<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/security.php');	
	
	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$purchaseDetailsSearchSql = 'SELECT * FROM purchase';
	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	$purchaseDetailsSearchStatement->execute();

	$output = '<table id="purchaseReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Purchase ID</th>
						<th>Item Number</th>
						<th>Purchase Date</th>
						<th>Item Name</th>
						<th>Vendor Name</th>
						<th>Vendor ID</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$uPrice = $row['unitPrice'];
		$qty = $row['quantity'];
		$totalPrice = $uPrice * $qty;
		
		$output .= '<tr>' .
						'<td>' . e($row['purchaseID']) . '</td>' .
						'<td>' . e($row['itemNumber']) . '</td>' .
						'<td>' . e($row['purchaseDate']) . '</td>' .
						'<td>' . e($row['itemName']) . '</td>' .
						'<td>' . e($row['vendorName']) . '</td>' .
						'<td>' . e($row['vendorID']) . '</td>' .
						'<td>' . e($row['quantity']) . '</td>' .
						'<td>' . e($row['unitPrice']) . '</td>' .
						'<td>' . e($totalPrice) . '</td>' .
					'</tr>';
	}
	
	$purchaseDetailsSearchStatement->closeCursor();
	
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
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>


