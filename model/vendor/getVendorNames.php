<?php
	require_once('../../inc/security.php');

	$vendorNamesSql = 'SELECT * FROM vendor';
	$vendorNamesStatement = $conn->prepare($vendorNamesSql);
	$vendorNamesStatement->execute();
	
	if($vendorNamesStatement->rowCount() > 0) {
		while($row = $vendorNamesStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="' . e($row['fullName']) . '">' . e($row['fullName']) . '</option>';
		}
	}
	$vendorNamesStatement->closeCursor();
?>