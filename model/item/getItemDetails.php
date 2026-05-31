<?php
	require_once('../../inc/security.php');

	$itemDetailsSql = 'SELECT * FROM item';
	$itemDetailsStatement = $conn->prepare($itemDetailsSql);
	$itemDetailsStatement->execute();
	
	if($itemDetailsStatement->rowCount() > 0) {
		while($row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option>' . e($row['itemName']) . '</option>';
		}
	}
	$itemDetailsStatement->closeCursor();
?>